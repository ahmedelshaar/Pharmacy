# Pharmacy-System

## Introduction

Pharmacy-System is a Laravel-based pharmacy system that simplifies the process of ordering and delivering medication. It
provides a comprehensive solution for pharmacists, doctors, and clients to manage their orders and prescriptions from a
single platform. Clients can easily place orders through a user-friendly interface, while pharmacists can add new
medicines and doctors can optimize the flow of orders to ensure the best possible outcome for clients. The system's
dashboard allows users to track order progress and status, and advanced features like DataTables ensure seamless
operations for both clients and administrators.

Pharmacy-System is a highly versatile and customizable system that can be tailored to the unique needs of healthcare
providers. It is a secure and reliable solution that streamlines medication management, enhances the customer
experience, and improves the quality of patient care.

## Technologies Used

- PHP Laravel
- JavaScript
- Bootstrap
- AdminLTE
- HTML
- Stripe Payment Gateway

## Features

- Authentication.
- Permissions and Roles.
- Automated email notifications for account verification, greeting, order confirmation, and inactive account reminders.
- Auto-assignment of orders to the nearest available pharmacy.
- Display total revenue for pharmacies and admins, with pharmacy-specific revenue for pharmacists and total revenue for
  admins.
- Utilizing DataTables for optimized viewing and management of data.
- User Profiles with Role-based Access Control.
- Stripe package for secure and seamless payment.
- Admin can ban and unban doctors for a period of three days.

## To create an admin

```bash
  php artisan create:admin --email=name@example.com --password=123456

```

