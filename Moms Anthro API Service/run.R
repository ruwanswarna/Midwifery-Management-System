#!/usr/bin/env Rscript

script_argument <- commandArgs(trailingOnly = FALSE)
script_file <- sub("^--file=", "", script_argument[grep("^--file=", script_argument)])
api_root <- if (length(script_file)) {
  normalizePath(dirname(script_file[[1L]]), mustWork = TRUE)
} else {
  normalizePath(getwd(), mustWork = TRUE)
}

Sys.setenv(MOMS_ANTHRO_API_ROOT = api_root)
setwd(api_root)

# Dependencies are installed beside this project so they do not alter the
# user's global R library. Make that local library available before loading
# plumber.
local_library <- file.path(api_root, "r-library")
if (dir.exists(local_library)) {
  .libPaths(c(local_library, .libPaths()))
}

if (!requireNamespace("plumber", quietly = TRUE)) {
  stop("The plumber package is not installed. Run install_dependencies.R first.", call. = FALSE)
}

host <- Sys.getenv("MOMS_ANTHRO_HOST", unset = "127.0.0.1")
port <- suppressWarnings(as.integer(Sys.getenv("MOMS_ANTHRO_PORT", unset = "8000")))
if (is.na(port) || port < 1L || port > 65535L) stop("MOMS_ANTHRO_PORT must be a valid port.", call. = FALSE)

api <- plumber::plumb(file.path(api_root, "plumber.R"))
message(sprintf("MOMS WHO Anthro API listening on http://%s:%d", host, port))
api$run(host = host, port = port)
