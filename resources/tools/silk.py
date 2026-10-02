"""Silk waves: a large, smooth ribbon of fine lines, like light folding over water.

Generates the brand background images in public/images/ (run: python3 resources/tools/silk.py).
Each ribbon is ~90 thin sine curves whose phase and height drift slowly from one curve to the
next, so together they read as one twisting surface. Lines are drawn additively on a black
canvas, softened with a glow, then saved as RGBA where alpha follows brightness, so the same
file works on navy (light lines) or white (tinted lines) backgrounds.
"""
import numpy as np
from PIL import Image, ImageFilter

OUT = 'public/images/'


def ribbon(w, h, seed=3, lines=80, amp=.24, waves=1.0, twist=1.05, y0=.6, tilt=-.2, spread=.22):
    rng = np.random.default_rng(seed)
    S = 2  # supersample
    W, H = w * S, h * S
    acc = np.zeros((H, W), np.float32)
    x = np.linspace(0, 1, W)
    for i in range(lines):
        t = i / (lines - 1)
        # each line: same base wave, phase and amplitude drift = the fold of the ribbon
        ph = 2.2 + twist * t * np.pi
        a = amp * (0.55 + 0.45 * np.cos(np.pi * t))
        y = y0 + tilt * (x - .5) + a * np.sin(2 * np.pi * waves * x + ph) * (0.6 + 0.4 * np.sin(np.pi * x)) + (t - .5) * spread
        py = y * H
        # brightness: strongest in the middle of the ribbon and where lines bunch together (fold)
        b = (0.35 + 0.65 * np.sin(np.pi * t) ** 2) * (0.5 + 0.5 * np.abs(np.cos(2 * np.pi * waves * x + ph)))
        yi = np.clip(py.astype(int), 0, H - 2)
        fr = py - yi
        cols = np.arange(W)
        np.add.at(acc, (yi, cols), b * (1 - fr) * .9)
        np.add.at(acc, (yi + 1, cols), b * fr * .9)
    img = Image.fromarray(np.clip(acc * 255, 0, 255).astype(np.uint8))
    img = img.resize((w, h), Image.LANCZOS)
    a = np.asarray(img).astype(np.float32) / 255
    glow = np.asarray(img.filter(ImageFilter.GaussianBlur(w / 90))).astype(np.float32) / 255
    halo = np.asarray(img.filter(ImageFilter.GaussianBlur(w / 25))).astype(np.float32) / 255
    v = np.clip(a * 1.5 + glow * 1.1 + halo * .55, 0, 1)
    return v


def save(v, rgb, name, gain=1.0):
    h, w = v.shape
    out = np.zeros((h, w, 4), np.uint8)
    out[..., 0], out[..., 1], out[..., 2] = rgb
    # bright core of the fold goes toward white on dark backgrounds
    out[..., 3] = np.clip(v * 255 * gain, 0, 255).astype(np.uint8)
    Image.fromarray(out, 'RGBA').save(OUT + name, 'WEBP', quality=88, method=6)


if __name__ == '__main__':
    hero = ribbon(2400, 1300)
    save(hero, (64, 150, 255), 'silk-hero.webp')
    band = ribbon(2400, 700, seed=7, amp=.3, waves=.8, y0=.55, tilt=.1, spread=.2)
    save(band, (0, 123, 255), 'silk-band.webp', .55)
    tile = ribbon(1200, 900, seed=11, amp=.28, waves=.9, y0=.5, tilt=-.3, twist=2.2)
    save(tile, (64, 150, 255), 'silk-tile.webp')
