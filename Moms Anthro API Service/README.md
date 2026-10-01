# MOMS WHO Anthro API

This service makes the supplied WHO `anthro` 1.1.0 R package available to your
PHP-based Midwifery Outcomes Management System (MOMS) through a local web API.
It calculates the official Anthro z-scores and can calculate population
prevalence statistics for reports.

## What it provides

- `POST /v1/zscores` — HAZ, WAZ, WHZ, BAZ and the optional head, arm, and
  skinfold z-scores for one or many children.
- `POST /v1/prevalence` — WHO prevalence, confidence intervals, standard
  errors, and grouping outputs for a set of children.
- `GET /health` — a simple availability check for MOMS.
- Optional API-key authentication and optional CORS restriction.

The API deliberately returns Anthro's raw z-score and quality-flag columns,
not just a "normal/abnormal" label. Save the raw result with the measurement in
MOMS. It lets you audit a clinical alert and regenerate reports later.

## Installation on your Windows MOMS server

1. Install R for Windows. Use an R version compatible with the supplied
   Anthro 1.1.0 package; the provided binary was built with R 4.7.0.
2. Open Command Prompt in this folder and run:

   ```bat
   Rscript install_dependencies.R
   ```

   This installs `plumber` and `jsonlite` into the local `r-library` folder,
   then installs the supplied `vendor/anthro_1.1.0.zip` package.
3. Configure an API key before production use. For the current Command Prompt:

   ```bat
   set MOMS_ANTHRO_API_KEY=replace-this-with-a-long-random-secret
   ```

4. Start the service:

   ```bat
   Rscript run.R
   ```

5. Check `http://127.0.0.1:8000/health` in a browser. Keep this window open,
   or register the command as a Windows service for always-on use.

The default host is `127.0.0.1`, so only PHP on the same machine can call it.
For a separate MOMS web server, set `MOMS_ANTHRO_HOST=0.0.0.0`, protect the
server with a firewall, and keep `MOMS_ANTHRO_API_KEY` set.

## Calling it from PHP

Use the ready-to-copy cURL wrapper in
[`docs/php-client-example.php`](docs/php-client-example.php). It sends a batch
of records and throws an exception if the R service reports an error.

For a child measurement page, calculate `age_days` from the child's date of
birth and the exact measurement date in PHP, then send `sex`, `weight_kg`,
`length_height_cm`, and the actual measurement position (`L` or `H`). The API
returns fields such as `zlen`, `zwei`, and `zwfl`; MOMS can save them in your
growth-measurement table.

Example command after startup:

```bat
curl -X POST http://127.0.0.1:8000/v1/zscores -H "Content-Type: application/json" --data @tests/zscore-request.json
```

See [the complete API reference](docs/API.md) for all fields, responses, and
prevalence reporting.

## Important measurement notes

- Use exact age in days whenever possible. Month-based age is less precise.
- Weight is kg; length/height is cm; skinfold measurements are mm.
- `L` means recumbent length and `H` means standing height. Anthro applies the
  WHO age-based conversion when the position and child's age differ.
- Anthro flags implausible z-scores with fields beginning `f`. Review them;
  do not automatically treat a flagged result as a clinical diagnosis.
- Oedema makes weight-related z-scores unavailable, as specified by Anthro.

## Development check

The project includes a valid request body at `tests/zscore-request.json`. This
workspace did not include an R runtime, so install and runtime verification
must be performed on the machine that will host the service.
