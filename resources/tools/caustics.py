"""Seamless (tileable) water caustics texture, white on transparent."""
import numpy as np, sys
from PIL import Image, ImageFilter
N = int(sys.argv[1]) if len(sys.argv) > 1 else 1024
cells = int(sys.argv[2]) if len(sys.argv) > 2 else 26
seed = int(sys.argv[3]) if len(sys.argv) > 3 else 7
out = sys.argv[4] if len(sys.argv) > 4 else 'caustics.png'
rng = np.random.default_rng(seed)

y, x = np.mgrid[0:N, 0:N] / N
# Periodic domain warp so the cells bend like light through moving water.
def pnoise(x, y, terms, kmax=4):
    v = np.zeros_like(x)
    for _ in range(terms):
        kx, ky = rng.integers(-kmax, kmax + 1, 2)
        if kx == 0 and ky == 0: continue
        v += np.sin(2*np.pi*(kx*x + ky*y) + rng.uniform(0, 2*np.pi)) / np.hypot(kx, ky)
    return v
wx = x + 0.032 * pnoise(x, y, 12, 3)
wy = y + 0.032 * pnoise(x, y, 12, 3)

pts = rng.random((cells * cells // 6, 2))
F1 = np.full((N, N), 9.0); F2 = np.full((N, N), 9.0)
for px, py in pts:
    dx = wx - px; dx -= np.round(dx)
    dy = wy - py; dy -= np.round(dy)
    d = np.hypot(dx, dy)
    F2 = np.where(d < F1, F1, np.minimum(F2, d))
    F1 = np.minimum(F1, d)
edge = F2 - F1
scale = 1.0 / np.sqrt(len(pts))
c = np.exp(-edge / (0.045 * scale))          # bright thin filaments
c += 0.35 * np.exp(-edge / (0.16 * scale))   # soft glow around them
c = c / c.max()
# Uneven light, like sunlight through a moving surface.
m = pnoise(x, y, 8, 2); m = (m - m.min()) / (m.max() - m.min())
c = c * (0.25 + 0.75 * m ** 1.4)
c = np.clip(c, 0, 1) ** 1.25
img = Image.fromarray((c * 255).astype(np.uint8), 'L')
img = img.filter(ImageFilter.GaussianBlur(N / 500))
rgba = Image.merge('RGBA', [Image.new('L', img.size, 255)] * 3 + [img])
rgba.save(out)
# Preview on water colour, tiled 2x2 to check seams.
prev = Image.new('RGB', (N * 2, N * 2), (19, 160, 190))
for i in range(2):
    for j in range(2):
        prev.paste(rgba, (i * N, j * N), rgba)
prev.resize((N, N)).save('preview-' + out.replace('.webp', '.png'))
