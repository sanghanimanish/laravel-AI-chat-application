# 🤖 Laravel AI Chatbot System

A modular AI-powered chatbot application built with Laravel.  
This system supports multiple AI providers (OpenAI & Gemini) using a clean Provider-based architecture.

---

## 🚀 Overview

This project is designed with scalability and clean architecture in mind.

Features:

- Multi AI provider support (OpenAI / Gemini)
- Service Layer architecture
- Provider (Strategy) Pattern implementation
- Database-based chat storage
- Config-driven provider switching
- Feature & Unit testing support
- Clean frontend chatbot UI

---

## 🏗 Architecture

The application follows:

- Service Layer Pattern
- Strategy Design Pattern (via Provider Interface)
- Interface-based AI switching
- Config-driven provider selection

### Folder Structure

```
app/
 ├── Http/Controllers/
 │    └── ChatbotController.php
 │
 ├── Models/
 │    ├── ChatMessage.php
 │    └── User.php
 │
 ├── Services/
 │    ├── AIChatService.php
 │    └── Providers/
 │         ├── ChatbotProviderInterface.php
 │         ├── OpenAIProvider.php
 │         └── GeminiProvider.php
```

---

## ✨ Features

### 🤖 AI Features
- Switch between OpenAI & Gemini
- Easy to extend new AI providers
- Config-based provider control

### 💬 Chat System
- Store user messages
- Store AI responses
- Chat history saved in database
- Frontend chatbot interface

### 🧪 Testing
- Feature tests
- Unit tests
- Chatbot-specific test coverage

---

## 🛠 Tech Stack

- PHP 8+
- Laravel 10+
- SQLite / MySQL
- Vite
- Vanilla JavaScript

---

# ⚙️ Installation Guide

## 1️⃣ Clone Repository

```bash
git clone https://github.com/your-username/laravel-ai-chatbot.git
cd laravel-ai-chatbot
```

## 2️⃣ Install Dependencies

```bash
composer install
npm install
npm run build
```

## 3️⃣ Setup Environment

```bash
cp .env.example .env
```

Update `.env` file:

```
APP_NAME="Laravel AI Chatbot"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

CHATBOT_PROVIDER=openai   # openai | gemini

OPENAI_API_KEY=your_openai_key
GEMINI_API_KEY=your_gemini_key
```

## 4️⃣ Generate App Key

```bash
php artisan key:generate
```

## 5️⃣ Run Migrations

```bash
php artisan migrate
```

## 6️⃣ Start Development Server

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000
```

---

# 🔄 Switching AI Provider

You can change provider from `.env`:

```
CHATBOT_PROVIDER=openai
```

Available providers:

- openai
- gemini

You can easily add new providers by implementing:

```
ChatbotProviderInterface
```

---

# 🗄 Database Structure

## chat_messages table

| Column     | Description        |
|------------|-------------------|
| id         | Primary key       |
| user_id    | Related user      |
| message    | User message      |
| response   | AI response       |
| created_at | Timestamp         |

---

# 📂 Important Files

- `AIChatService.php` → Handles provider communication
- `ChatbotProviderInterface.php` → Defines AI contract
- `OpenAIProvider.php` → OpenAI integration
- `GeminiProvider.php` → Gemini integration
- `ChatbotController.php` → Handles chat requests

---

# 🧪 Run Tests

```bash
php artisan test
```

---

# 🔐 Security

- API keys stored securely in `.env`
- CSRF protection enabled
- Config-based provider control
- Request validation

---

# 🚀 Production Deployment

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```