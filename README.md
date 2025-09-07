# 📝 Draftly – Modern Blog Platform  

Draftly is a feature-rich **blog website** built from scratch using **PHP (OOP + MVC)** on the backend and **AJAX** on the frontend for smooth, asynchronous interactions.  
It’s designed to be clean, scalable, and secure, featuring both a **public blog platform** and a powerful **admin panel** for content moderation.  

---

## 🚀 Features

### 🌍 Public Website
- Browse blogs with **infinite scroll** (AJAX-based)
- **Search & filter** blogs by category or keyword
- Blog detail pages with **views count tracking**
- Mobile-friendly & responsive UI
- User-friendly **Quill editor styling** for content readability
- SEO-friendly structure with categories and clean URLs

### 🔐 Admin Panel
- Secure authentication & admin middleware
- Manage blogs (create, update, delete, approve)
- Manage categories dynamically
- Manage users (add, update, delete, role-based permissions)
- **Image upload & deletion system** (with safe file handling)
- Pending/approved blog workflow for content moderation

### ⚙️ Backend (PHP)
- **MVC architecture** for clear separation of concerns
- **OOP-based models & controllers**
- Reusable middleware for authentication & admin access
- Secure SQL queries with **prepared statements**
- Input validation & error handling
- Safe file upload handling (size/type checks, unique filenames, path sanitization)

### ⚡ Frontend (AJAX + JS)
- AJAX-powered CRUD operations (no page reloads)
- **Intersection Observer** for infinite scrolling blogs
- Dynamic search form with history updates
- Inline feedback with loaders & error messages
- Vanilla JavaScript – lightweight & fast

---

## 🏗️ Tech Stack
- **Language**: PHP 8+
- **Database**: MySQL
- **Frontend**: HTML, CSS (Bootstrap), JavaScript (AJAX)
- **Text Editor**: Quill.js (rich-text editor for blogs)
- **Architecture**: MVC + OOP principles

---

## 📂 Project Structure
draftly-blog/
│──admin/ # Admin files
│── controllers/ # Controllers (BlogController, UserController, etc.)
│── middlewares/ # Auth & Admin middleware
│── models/ # Database models
│── public/ # Public assets (images, CSS, JS)
│── views/ # Frontend templates (blogs, admin panel)
│── handler/ # AJAX handler (controller/action router)
│── index.php # Entry point
│── README.md # Documentation



---

## ⚡ Installation & Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/draftly-blog.git
   cd draftly-blog
