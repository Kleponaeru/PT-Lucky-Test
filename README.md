# Laravel WhatsApp Export using UltraMSG & Ngrok

This project allows sending Excel reports of students via WhatsApp from a local Laravel app.

- **UltraMSG API**: Used to send WhatsApp messages and documents.
- **Ngrok**: Exposes the local Laravel server publicly so UltraMSG can access files.

**How it works:**
1. Generate Excel report (`laporan-mahasiswa.xlsx`) in Laravel.
2. Save file to `public/storage`.
3. Use Ngrok public URL or Base64 encoding to make file accessible.
4. Send file via UltraMSG API to WhatsApp number.

Note: .sql are on root directory
