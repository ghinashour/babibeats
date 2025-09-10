# Babibeats API Service

## Introduction

Babibeats is a modern music platform designed to connect listeners with songs, artists, and playlists in a personalized way.  
This repository contains the **backend API service** for Babibeats, developed using **Laravel** and **SQLite**.

The API will provide endpoints for user authentication, music data retrieval, search functionality, playlist management, and personalized recommendations.  
It will serve as the foundation for future web and mobile applications that interact with the Babibeats ecosystem.

---

## Project Proposal

### 1. Project Overview

Babibeats is a musical platform that connects users with songs, artists, and playlists in a personalized and engaging way.

The **Babibeats API Service** will be developed using **Laravel** and will serve as the backend for the platform, providing a secure and efficient way for client applications (web, mobile, or third-party integrations) to interact with music content and user data stored in an **SQLite database**.

---

### 2. Objectives

-   Build a **RESTful API** using Laravel that supports core music platform functionalities.
-   Ensure **secure, authenticated** user interactions.
-   Implement **search, playlist management, and recommendations**.
-   Maintain **performance, scalability, and clean code architecture**.

---

### 3. Main Functionalities

#### A. User Management

-   **Registration & Login** (JWT authentication via Laravel Sanctum or Passport)
-   Profile management (update name, email, password)
-   Secure password storage (Laravel's hashing mechanism)

#### B. Music Data Retrieval

-   Retrieve song details (title, artist, album, duration, genre, release date)
-   Get album details and associated tracks
-   Get artist profiles and their songs
-   Provide secure streaming URLs

#### C. Search & Discovery

-   Search songs, albums, and artists
-   Browse by genre or popularity
-   Discover trending and recommended music

#### D. Playlist Management

-   Create, update, and delete playlists
-   Add/remove songs from playlists
-   Retrieve user playlists

#### E. Recommendations

-   Personalized song recommendations based on listening history
-   Suggest similar artists/tracks

#### F. User Interaction

-   Like/unlike songs
-   Retrieve most liked songs

---

### 4. Technology Stack

-   **Backend Framework:** Laravel (PHP)
-   **Database:** SQLite
-   **Authentication:** Laravel Sanctum / Passport (JWT)
-   **API Documentation:** Laravel API resources + Postman collection
-   **Hosting (future):** AWS, Render, or Heroku

---
