# Idea Tracker

A full-stack web application built with **Laravel** for creating, organizing, and tracking personal ideas — with Google OAuth login, Markdown-enabled descriptions, and progress tracking.

--
## Overview

Idea Tracker helps users capture and manage their ideas from first thought to completion. Each idea can include a title, a rich description, actionable steps, links, and an image — with real-time status tracking to see what's pending, in progress, or done.

---

## Features

- **Authentication** — Register/login with username, email & password
- **Google OAuth Login** — Sign in with Google using Laravel Socialite
- **Profile Management** — Users can edit their profile information
- **Idea Management (CRUD)** — Create, edit, and delete ideas
- **Rich Idea Details** — Each idea includes:
  - Title & Description (supports **Markdown**)
  - Auto-detected links and emails inside the description are rendered as clickable elements
  - Status (Pending / In Progress / Completed)
  - Step-by-step breakdown
  - Related links
  - Cover image
- **Progress Dashboard** — See how many ideas are Pending, In Progress, or Completed at a glance
- **Clean Architecture** — Business logic for creating/updating ideas is extracted into dedicated **Action classes**, decoupled from controllers, following the Single Responsibility Principle

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel, PHP |
| Database | SQLite |
| Frontend | Blade, Tailwind CSS, JavaScript |
| Auth | Laravel Breeze/Fortify + Socialite (Google OAuth) |

---

## Architecture Highlights

Instead of stuffing logic into controllers, idea creation and updates are handled by dedicated **Action classes** (`CreateIdea`, `UpdateIdeaAction`), which keeps controllers thin and business logic reusable and testable.

 ├── Http/Controllers/
 │    └── IdeaController.php
 └── Models/
      └── Idea.php
```
