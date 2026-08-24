import os
import glob
from PIL import Image

uploaded_dir = r"C:\Users\Asus\.gemini\antigravity\brain\08c433f5-9a6e-4371-bec3-0bcadf77413d\.user_uploaded"

files = glob.glob(os.path.join(uploaded_dir, "*.*"))
print(f"Total uploaded files: {len(files)}")

for f in sorted(files, key=os.path.getmtime):
    try:
        im = Image.open(f)
        size_kb = os.path.getsize(f) / 1024
        print(f"{os.path.basename(f)}: size={im.size}, mode={im.mode}, format={im.format}, {size_kb:.1f} KB")
    except Exception as e:
        print(f"{os.path.basename(f)}: {e}")
