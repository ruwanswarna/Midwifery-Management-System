# API reference

Base URL while running locally: `http://127.0.0.1:8000`

All requests and responses use JSON. If `MOMS_ANTHRO_API_KEY` is set, send it
as `X-API-Key` for every endpoint except `GET /health`.

## `GET /health`

Checks that the service and the Anthro package are available.

```json
{
  "ok": true,
  "service": "moms-who-anthro-api",
  "anthro_version": "1.1.0"
}
```

## `POST /v1/zscores`

Calculates WHO growth z-scores for one or many children. The request body has
one `records` array. `sex` and at least one measurement are required for each
record. Use precise `age_days` whenever MOMS has the date of birth and the
measurement date; `age_months` is accepted as a convenience and is converted
to days.

```json
{
  "records": [
    {
      "id": "127",
      "sex": "Female",
      "age_days": 730,
      "weight_kg": 10.8,
      "length_height_cm": 84.5,
      "measurement_position": "H",
      "head_circumference_cm": 47.2,
      "oedema": "no"
    }
  ]
}
```

Accepted `sex` values are `Male`, `Female`, `M`, `F`, `1` (male), and `2`
(female). `measurement_position` is `L` for recumbent length or `H` for
standing height. All measurements must use these units: weight in kg;
length/height, head circumference, and arm circumference in cm; triceps and
subscapular skinfolds in mm.

The response contains the original Anthro output in `measurements`, plus a
MOMS-friendly classification. The most useful output fields are:

| Anthro field | Meaning | MOMS use |
|---|---|---|
| `zlen` | Length/height-for-age z-score (HAZ) | Stunting monitoring |
| `zwei` | Weight-for-age z-score (WAZ) | Underweight monitoring |
| `zwfl` | Weight-for-length/height z-score (WHZ) | Wasting monitoring |
| `zbmi` | BMI-for-age z-score (BAZ) | BMI assessment |
| `zhc` | Head-circumference-for-age z-score | Infant growth tracking |
| `zac` | Arm-circumference-for-age z-score | Nutrition assessment |
| `f*` fields | Anthro quality flags | Do not treat flagged values as reliable without review |

`severe_low` is below -3 SD; `moderate_low` is from -3 SD up to but not
including -2 SD; `within_reference_range` is -2 to +2 SD. `high` and
`very_high` correspond to above +2 and +3 SD respectively. The classification
is a display aid; retain and report the numerical z-score.

## `POST /v1/prevalence`

Uses the same `records` structure to produce WHO prevalence estimates across a
group. It returns the complete Anthro table in `groups`. Add these optional
fields to records when you need survey-design or grouped reporting:

| Input field | Anthro argument | Purpose |
|---|---|---|
| `sample_weight` | `sw` | Sampling weight |
| `cluster` | `cluster` | Sampling cluster |
| `strata` | `strata` | Survey stratum |
| `residence_type` | `typeres` | Rural/Urban grouping |
| `geographical_region` | `gregion` | Region grouping |
| `wealth_quintile` | `wealthq` | Wealth grouping |
| `mother_education` | `mothered` | Mother education grouping |
| `other_group` | `othergr` | One additional grouping |

For normal MOMS registry reporting, submit the eligible children with no survey
design fields. `anthro` then uses its simple, fast calculation path. For formal
population-survey statistics, include the correct sample design data.

## Error responses

Validation and package errors use HTTP 400. Authentication failures use HTTP
401. The error body is always:

```json
{
  "ok": false,
  "error": { "message": "Description of the problem", "details": null }
}
```
