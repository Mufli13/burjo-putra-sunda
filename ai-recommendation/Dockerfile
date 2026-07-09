# Gunakan Python 3.11 yang ringan
FROM python:3.11-slim

# Set folder kerja di dalam container
WORKDIR /app

# Copy file requirements dulu (untuk cache)
COPY requirements.txt .

# Install semua library
RUN pip install --no-cache-dir -r requirements.txt

# Copy semua file project
COPY . .

# Buka port 8000
EXPOSE 8000

# Perintah menjalankan FastAPI
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]