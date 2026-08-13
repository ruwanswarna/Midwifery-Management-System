/** Draws a normalized WHO growth-chart image inside the Chart.js chartArea. */
export const whoGrowthBackground = {
  id: "whoGrowthBackground",
  beforeDraw(chart, _args, options) {
    const image = options?.image;
    if (!image?.complete || !image.naturalWidth) return;

    const { ctx, chartArea } = chart;
    const { left, top, right, bottom } = chartArea;
    ctx.save();
    ctx.globalAlpha = options.opacity ?? 1;
    ctx.drawImage(image, left, top, right - left, bottom - top);
    ctx.restore();
  },
};

export function loadGrowthBackground(url) {
  return new Promise((resolve, reject) => {
    const image = new Image();
    image.onload = () => resolve(image);
    image.onerror = () => reject(new Error(`Unable to load growth background: ${url}`));
    image.src = url;
  });
}

/**
 * Produces the common Chart.js options. The chart ID selects all scale bounds,
 * so callers never provide image start/end pixels.
 */
export function growthChartOptions(spec, image) {
  return {
    responsive: true,
    maintainAspectRatio: false,
    parsing: false,
    animation: false,
    plugins: {
      legend: { display: false },
      whoGrowthBackground: { image, opacity: 1 },
    },
    scales: {
      x: {
        type: "linear",
        min: spec.x.min,
        max: spec.x.max,
        title: { display: true, text: `${spec.x.measure} (${spec.x.unit})` },
        grid: { display: false },
      },
      y: {
        type: "linear",
        min: spec.y.min,
        max: spec.y.max,
        title: { display: true, text: `${spec.y.measure} (${spec.y.unit})` },
        grid: { display: false },
      },
    },
  };
}
