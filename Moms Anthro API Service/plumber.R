# MOMS WHO Anthro API
# A small HTTP wrapper around WHO's anthro R package.

api_root <- normalizePath(
  Sys.getenv("MOMS_ANTHRO_API_ROOT", unset = getwd()),
  mustWork = FALSE
)
local_library <- file.path(api_root, "r-library")
if (dir.exists(local_library)) {
  .libPaths(c(local_library, .libPaths()))
}

if (!requireNamespace("anthro", quietly = TRUE)) {
  stop(
    "The anthro package is not installed. Run install_dependencies.R from the API folder first.",
    call. = FALSE
  )
}

`%||%` <- function(value, fallback) if (is.null(value)) fallback else value

api_error <- function(res, status, message, details = NULL) {
  res$status <- status
  list(
    ok = FALSE,
    error = list(message = message, details = details)
  )
}

set_common_headers <- function(res) {
  allowed_origin <- Sys.getenv("MOMS_ANTHRO_ALLOWED_ORIGIN", unset = "")
  if (nzchar(allowed_origin)) {
    res$setHeader("Access-Control-Allow-Origin", allowed_origin)
    res$setHeader("Vary", "Origin")
  }
  res$setHeader("Access-Control-Allow-Headers", "Content-Type, X-API-Key")
  res$setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS")
}

read_request_body <- function(req) {
  raw_body <- req$postBody %||% req$bodyRaw

  if (is.raw(raw_body)) {
    raw_body <- rawToChar(raw_body)
  }

  if (
    is.character(raw_body) &&
    length(raw_body) == 1L &&
    nzchar(raw_body)
  ) {
    return(
      jsonlite::fromJSON(
        raw_body,
        simplifyVector = FALSE
      )
    )
  }

  body <- req$body

  if (!is.list(body)) {
    stop(
      "Request body must be a non-empty JSON object.",
      call. = FALSE
    )
  }

  # Plumber's JSON parser may convert records into a data frame.
  if (is.data.frame(body$records)) {
    body$records <- lapply(
      seq_len(nrow(body$records)),
      function(index) {
        as.list(body$records[index, , drop = FALSE])
      }
    )
  }

  body
}

as_character_value <- function(value, default = NA_character_) {
  if (is.null(value) || length(value) == 0L || is.na(value[[1L]])) {
    return(default)
  }
  result <- trimws(as.character(value[[1L]]))
  if (!nzchar(result)) default else result
}

as_numeric_value <- function(value, default = NA_real_) {
  if (is.null(value) || length(value) == 0L || is.na(value[[1L]])) {
    return(default)
  }
  result <- suppressWarnings(as.numeric(value[[1L]]))
  if (is.na(result)) default else result
}

get_value <- function(record, names, default = NULL) {
  for (name in names) {
    if (!is.null(record[[name]])) {
      return(record[[name]])
    }
  }
  default
}

normalise_sex <- function(value) {
  sex <- tolower(as_character_value(value, default = ""))
  if (sex %in% c("1", "m", "male")) return("m")
  if (sex %in% c("2", "f", "female")) return("f")
  NA_character_
}

normalise_measure <- function(value) {
  measure <- toupper(as_character_value(value))
  if (measure %in% c("L", "H")) measure else NA_character_
}

normalise_oedema <- function(value) {
  oedema <- tolower(as_character_value(value, default = "n"))
  if (oedema %in% c("y", "yes", "1")) "y" else "n"
}

record_age_days <- function(record) {
  days <- as_numeric_value(get_value(record, c("age_days", "age")))
  if (!is.na(days)) return(days)

  months <- as_numeric_value(get_value(record, c("age_months")))
  if (is.na(months)) NA_real_ else round(months * 30.4375)
}

to_optional_vector <- function(values) {
  if (all(is.na(values))) NULL else values
}

build_vectors <- function(records) {
  if (!is.list(records) || length(records) == 0L) {
    stop("records must be a non-empty JSON array.", call. = FALSE)
  }
  if (!all(vapply(records, is.list, logical(1)))) {
    stop("Each item in records must be a JSON object.", call. = FALSE)
  }

  vectors <- list(
    id = vapply(records, function(r) as_character_value(r$id, default = NA_character_), character(1)),
    sex = vapply(records, function(r) normalise_sex(r$sex), character(1)),
    age = vapply(records, record_age_days, numeric(1)),
    weight = vapply(records, function(r) as_numeric_value(get_value(r, c("weight_kg", "weight"))), numeric(1)),
    lenhei = vapply(records, function(r) as_numeric_value(get_value(r, c("length_height_cm", "lenhei"))), numeric(1)),
    measure = vapply(records, function(r) normalise_measure(get_value(r, c("measurement_position", "measure"))), character(1)),
    headc = vapply(records, function(r) as_numeric_value(get_value(r, c("head_circumference_cm", "headc"))), numeric(1)),
    armc = vapply(records, function(r) as_numeric_value(get_value(r, c("arm_circumference_cm", "armc"))), numeric(1)),
    triskin = vapply(records, function(r) as_numeric_value(get_value(r, c("triceps_skinfold_mm", "triskin"))), numeric(1)),
    subskin = vapply(records, function(r) as_numeric_value(get_value(r, c("subscapular_skinfold_mm", "subskin"))), numeric(1)),
    oedema = vapply(records, function(r) normalise_oedema(r$oedema), character(1)),
    sw = vapply(records, function(r) as_numeric_value(get_value(r, c("sample_weight", "sw"))), numeric(1)),
    cluster = vapply(records, function(r) as_numeric_value(r$cluster), numeric(1)),
    strata = vapply(records, function(r) as_numeric_value(r$strata), numeric(1)),
    typeres = vapply(records, function(r) as_character_value(get_value(r, c("residence_type", "typeres"))), character(1)),
    gregion = vapply(records, function(r) as_character_value(get_value(r, c("geographical_region", "gregion"))), character(1)),
    wealthq = vapply(records, function(r) as_character_value(get_value(r, c("wealth_quintile", "wealthq"))), character(1)),
    mothered = vapply(records, function(r) as_character_value(get_value(r, c("mother_education", "mothered"))), character(1)),
    othergr = vapply(records, function(r) as_character_value(get_value(r, c("other_group", "othergr"))), character(1))
  )

  invalid_sex <- which(is.na(vectors$sex))
  if (length(invalid_sex)) {
    stop(sprintf("sex is required and must be Male/Female, M/F, 1, or 2 (records: %s).", paste(invalid_sex, collapse = ", ")), call. = FALSE)
  }

  measurements <- cbind(vectors$weight, vectors$lenhei, vectors$headc, vectors$armc, vectors$triskin, vectors$subskin)
  empty_records <- which(rowSums(!is.na(measurements)) == 0L)
  if (length(empty_records)) {
    stop(sprintf("At least one measurement is required (records: %s).", paste(empty_records, collapse = ", ")), call. = FALSE)
  }

  vectors
}

data_frame_records <- function(data, ids = NULL) {
  records <- lapply(seq_len(nrow(data)), function(index) {
    row <- as.list(data[index, , drop = FALSE])
    if (!is.null(ids) && !is.na(ids[[index]])) row$id <- ids[[index]]
    row
  })
  records
}

classify_zscore <- function(value) {
  value <- as_numeric_value(value)
  if (is.na(value)) return("not_calculated")
  if (value < -3) return("severe_low")
  if (value < -2) return("moderate_low")
  if (value > 3) return("very_high")
  if (value > 2) return("high")
  "within_reference_range"
}

growth_interpretation <- function(row) {
  list(
    height_for_age = classify_zscore(row$zlen),
    weight_for_age = classify_zscore(row$zwei),
    weight_for_length_height = classify_zscore(row$zwfl),
    bmi_for_age = classify_zscore(row$zbmi),
    head_circumference_for_age = classify_zscore(row$zhc),
    arm_circumference_for_age = classify_zscore(row$zac)
  )
}

format_zscore_records <- function(result, ids) {
  lapply(seq_len(nrow(result)), function(index) {
    row <- as.list(result[index, , drop = FALSE])
    list(
      id = if (is.na(ids[[index]])) NULL else ids[[index]],
      measurements = row,
      interpretation = growth_interpretation(row)
    )
  })
}

#* @apiTitle MOMS WHO Anthro API
#* @apiDescription WHO Child Growth Standards calculations for the MOMS project.

#* Adds browser-safe CORS response headers and handles pre-flight requests.
#* @filter cors
function(req, res) {
  set_common_headers(res)
  if (identical(req$REQUEST_METHOD, "OPTIONS")) {
    res$status <- 204
    return("")
  }
  plumber::forward()
}

#* Checks an optional API key. Set MOMS_ANTHRO_API_KEY before production use.
#* @filter api_key
function(req, res) {
  expected_key <- Sys.getenv("MOMS_ANTHRO_API_KEY", unset = "")
  public_paths <- c("/health", "/openapi.json")
  if (identical(req$REQUEST_METHOD, "OPTIONS") || req$PATH_INFO %in% public_paths || !nzchar(expected_key)) {
    return(plumber::forward())
  }
  supplied_key <- req$HTTP_X_API_KEY %||% ""
  if (!identical(supplied_key, expected_key)) {
    return(api_error(res, 401, "Missing or invalid X-API-Key."))
  }
  plumber::forward()
}

#* Service status and installed package version.
#* @get /health
#* @serializer json
function(res) {
  list(
    ok = TRUE,
    service = "moms-who-anthro-api",
    anthro_version = as.character(utils::packageVersion("anthro"))
  )
}

#* Returns the fields and units accepted by the calculation endpoints.
#* @get /v1/metadata
#* @serializer json
function() {
  list(
    package = "WHO anthro",
    package_version = as.character(utils::packageVersion("anthro")),
    age = list(age_days = "Preferred: exact age in days.", age_months = "Accepted and converted to days."),
    required_per_record = c("sex", "at least one measurement"),
    measurements = list(
      weight_kg = "kg",
      length_height_cm = "cm",
      measurement_position = "L (recumbent length) or H (standing height)",
      head_circumference_cm = "cm",
      arm_circumference_cm = "cm",
      triceps_skinfold_mm = "mm",
      subscapular_skinfold_mm = "mm",
      oedema = "yes/no; weight-related z-scores are not calculated when yes"
    )
  )
}

#* Calculates WHO child-growth z-scores for one or more children.
#* @post /v1/zscores
#* @parser json
#* @serializer json
function(req, res) {
  tryCatch({
    body <- read_request_body(req)
    vectors <- build_vectors(body$records)
    scores <- anthro::anthro_zscores(
      sex = vectors$sex,
      age = vectors$age,
      is_age_in_month = FALSE,
      weight = vectors$weight,
      lenhei = vectors$lenhei,
      measure = vectors$measure,
      headc = vectors$headc,
      armc = vectors$armc,
      triskin = vectors$triskin,
      subskin = vectors$subskin,
      oedema = vectors$oedema
    )

    list(
      ok = TRUE,
      package_version = as.character(utils::packageVersion("anthro")),
      count = nrow(scores),
      results = format_zscore_records(scores, vectors$id)
    )
  }, error = function(error) {
    api_error(res, 400, conditionMessage(error))
  })
}

#* Calculates WHO prevalence estimates for a group of children.
#* @post /v1/prevalence
#* @parser json
#* @serializer json
function(req, res) {
  tryCatch({
    body <- read_request_body(req)
    vectors <- build_vectors(body$records)
    prevalence <- anthro::anthro_prevalence(
      sex = vectors$sex,
      age = vectors$age,
      is_age_in_month = FALSE,
      weight = vectors$weight,
      lenhei = vectors$lenhei,
      measure = vectors$measure,
      oedema = vectors$oedema,
      sw = to_optional_vector(vectors$sw),
      cluster = to_optional_vector(vectors$cluster),
      strata = to_optional_vector(vectors$strata),
      typeres = vectors$typeres,
      gregion = vectors$gregion,
      wealthq = vectors$wealthq,
      mothered = vectors$mothered,
      othergr = vectors$othergr
    )

    list(
      ok = TRUE,
      package_version = as.character(utils::packageVersion("anthro")),
      input_count = length(vectors$sex),
      groups = data_frame_records(prevalence)
    )
  }, error = function(error) {
    api_error(res, 400, conditionMessage(error))
  })
}
