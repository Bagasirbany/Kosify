import os

brain_dir = r"C:\Users\Asus\.gemini\antigravity\brain\08c433f5-9a6e-4371-bec3-0bcadf77413d"

images = []
for f in os.listdir(brain_dir):
    if f.lower().endswith(('.png', '.jpg', '.jpeg', '.webp', '.svg')):
        images.append(f)

print(f"Found {len(images)} images in brain directory:")
for img in sorted(images):
    print(" ", img)
