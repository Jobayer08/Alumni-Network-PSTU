# 🎓 Alumni Network Web Project

A PHP and MySQL-based web application for alumni to register, connect, participate in events, and chat with other members. Designed for universities or colleges to manage alumni engagement.

---

## 📌 Features

- ✅ Alumni Registration & Login  
- 🧾 Profile Management (with academic and job details)  
- 🔍 Search Alumni by name, course, year, location  
- 💬 Private Messaging/Chat between alumni  
- 📅 Event Registration with Payment  
- 🧾 Downloadable Payment Receipt (PDF)  
- 🛠️ Admin Panel for managing events, users, and reports  
- 📥 User & Admin Dashboard  

---

## 🛠 Technology Stack

| Layer        | Technology          |
|--------------|---------------------|
| Frontend     | HTML5, CSS3         |
| Backend      | PHP                 |
| Database     | MySQL               |
| Hosting      | InfinityFree        |
| FTP Upload   | FileZilla           |
| PDF Reports  | FPDF PHP Library    |

---

## 🧩 Database Design

- Tables:
  - `users`
  - `events`
  - `event_registrations`
  - `payments`
  - `messages`

- Relationships:
  - `event_registrations.user_id` → `users.id`
  - `event_registrations.event_id` → `events.id`
  - `payments.user_id` → `users.id`
  - `payments.event_id` → `events.id`

---
## 🚀 How to Run Locally

1. Clone this repo:
   ```bash
   git clone (https://github.com/Jobayer08/Alumni-Network-PSTU)
   cd alumni-network
   
2.Import the database:

Open phpMyAdmin

Create a new database, e.g., alumni_db

Import the provided .sql file into the database

3.Configure DB Connection:

Open db.php

Update MySQL credentials (host, username, password, dbname)

4.Start the server:

Use XAMPP or WAMP

Place files in htdocs directory (XAMPP)

🌐 Live Demo 
You can access the live version here:
🔗 https://alumninetworkpstu.free.nf

📦 Screenshots

| Feature        | Screenshot       |
| -------------- | ---------------- |
| Registration   |![image](https://github.com/user-attachments/assets/e6d2933f-14e6-4c43-a843-70d049578c3e)
 |
 | Dashboard   |![image](https://github.com/user-attachments/assets/39880a82-a04a-4d77-aabd-ad9940552471)

 |
| Chat System    | ![image](https://github.com/user-attachments/assets/b0796144-fb18-49ae-bac2-c5f8556cc919)
 |
| Event Register | ![image](https://github.com/user-attachments/assets/36806da5-50a3-4dd8-98f2-0397b0ab119e)
 |

 🙌 Acknowledgements
InfinityFree for free hosting

FPDF for PDF generation

MySQL & phpMyAdmin for database handling

📃 License
This project is for educational purposes. You may modify and use it as needed.


