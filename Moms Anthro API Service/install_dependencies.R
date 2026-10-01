#!/usr/bin/env Rscript
# Run once after extracting the project, from its root folder.

api_root <- normalizePath(getwd(), mustWork = TRUE)
local_library <- file.path(api_root, "r-library")
dir.create(local_library, recursive = TRUE, showWarnings = FALSE)
.libPaths(c(local_library, .libPaths()))

required_packages <- c("plumber", "jsonlite", "survey")
missing_packages <- required_packages[!vapply(required_packages, requireNamespace, logical(1), quietly = TRUE)]
if (length(missing_packages)) {
  install.packages(missing_packages, repos = "https://cloud.r-project.org", lib = local_library)
}

anthro_zip <- file.path(api_root, "vendor", "anthro_1.1.0.zip")
if (!file.exists(anthro_zip)) {
  stop("Missing vendor/anthro_1.1.0.zip. Keep the supplied WHO package in the vendor folder.", call. = FALSE)
}

installed_anthro <- requireNamespace("anthro", quietly = TRUE)
if (!installed_anthro || as.character(utils::packageVersion("anthro")) != "1.1.0") {
  if (.Platform$OS.type != "windows") {
    stop(
      "The supplied anthro_1.1.0.zip is a Windows binary package. Run this API on Windows, or install anthro 1.1.0 from CRAN on your Linux server.",
      call. = FALSE
    )
  }
  install.packages(anthro_zip, repos = NULL, type = "win.binary", lib = local_library)
}

message("Installation complete. Start the API with: Rscript run.R")
