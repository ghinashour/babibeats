# BabiBeats Music API Documentation

BabiBeats is a RESTful API for a music streaming service, built with Laravel. This documentation covers all available endpoints, required parameters, and example responses.

## Base URL

All endpoints are relative to the base URL of your deployment:
`http://your-app.com/api` or `http://localhost:8000/api` for local development.

## Authentication

This API uses Laravel Sanctum for token-based authentication. Most endpoints require a valid API token to be included in the request header.

### Login

Retrieves an API token for authenticated requests.

**Endpoint:** `POST /api/login`

**Request Body:**

```json
{
    "email": "user@example.com",
    "password": "yourpassword"
}
```

**Success Response:**

-   **Code:** 200 OK
-   **Content:**

```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    ...
  },
  "token": "1|abc123...xyz"
}
```

**Error Response:**

-   **Code:** 401 Unauthorized
-   **Content:** `{"message": "Invalid credentials"}`

### Making Authenticated Requests

After logging in, include the token in the `Authorization` header of all subsequent requests:

```
Authorization: Bearer your_api_token_here
```

### Logout

Invalidates the current API token.

**Endpoint:** `POST /api/logout`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Logged out"}`

---

## Public Endpoints (No Auth Required)

### Get All Artists

**Endpoint:** `GET /api/artists`

**Success Response:**

-   **Code:** 200 OK
-   **Content:**

```json
[
    {
        "id": 1,
        "name": "Artist Name",
        "bio": "Artist biography...",
        "profile_image": "path/to/image.jpg",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
    }
]
```

### Get Single Artist

**Endpoint:** `GET /api/artists/{id}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{ ...artist object... }`

### Get All Albums

**Endpoint:** `GET /api/albums`

**Success Response:**

-   **Code:** 200 OK
-   **Content:**

```json
[
  {
    "id": 1,
    "title": "Album Title",
    "release_date": "2023-01-01",
    "cover_image": "path/to/cover.jpg",
    "artist_id": 1,
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z",
    "artist": {
      "id": 1,
      "name": "Artist Name",
      ...
    }
  }
]
```

### Get Single Album

**Endpoint:** `GET /api/albums/{id}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{ ...album object with artist... }`

### Get All Tracks

**Endpoint:** `GET /api/tracks`

**Success Response:**

-   **Code:** 200 OK
-   **Content:**

```json
[
  {
    "id": 1,
    "title": "Track Title",
    "duration": 240,
    "file_path": "path/to/audio.mp3",
    "artist_id": 1,
    "album_id": 1,
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z",
    "artist": { ... },
    "album": { ... }
  }
]
```

### Get Single Track

**Endpoint:** `GET /api/tracks/{id}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{ ...track object with artist and album... }`

---

## Protected Endpoints (Authentication Required)

### Users

#### Get All Users

**Endpoint:** `GET /api/users`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `[ ...array of user objects... ]`

#### Get Current User Profile

**Endpoint:** `GET /api/users/{id}`
**Headers:** `Authorization: Bearer {token}`

**Note:** Users can only access their own profile. Attempting to access another user's profile will return a `403 Forbidden` error.

**Success Response:**

-   **Code:** 200 OK
-   **Content:**

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "user@example.com",
  "email_verified_at": null,
  "created_at": "2023-01-01T00:00:00.000000Z",
  "updated_at": "2023-01-01T00:00:00.000000Z",
  "playlists": [ ... ],
  "favorites": [ ... ],
  "listening_histories": [ ... ]
}
```

---

### Playlists

#### Get User's Playlists

**Endpoint:** `GET /api/playlists`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `[ ...array of the authenticated user's playlists... ]`

#### Get Single Playlist

**Endpoint:** `GET /api/playlists/{id}`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{ ...playlist object with tracks... }`

#### Create Playlist

**Endpoint:** `POST /api/playlists`
**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "name": "My New Playlist",
    "description": "Optional playlist description",
    "is_public": true
}
```

**Success Response:**

-   **Code:** 201 Created
-   **Content:** `{ ...created playlist object... }`

#### Update Playlist

**Endpoint:** `PUT /api/playlists/{id}`
**Headers:** `Authorization: Bearer {token}`

**Note:** Users can only update their own playlists.

**Request Body:** (All fields optional)

```json
{
    "name": "Updated Playlist Name",
    "description": "Updated description",
    "is_public": false
}
```

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{ ...updated playlist object... }`

#### Delete Playlist

**Endpoint:** `DELETE /api/playlists/{id}`
**Headers:** `Authorization: Bearer {token}`

**Note:** Users can only delete their own playlists.

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Playlist deleted successfully."}`

#### Add Track to Playlist

**Endpoint:** `POST /api/playlists/{id}/tracks`
**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "track_id": 5
}
```

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Track added to playlist successfully.", "data": { ...playlist with tracks... }}`

#### Remove Track from Playlist

**Endpoint:** `DELETE /api/playlists/{id}/tracks/{trackId}`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Track removed from playlist successfully.", "data": { ...playlist with tracks... }}`

---

### Tracks

#### Upload Track

**Endpoint:** `POST /api/tracks`
**Headers:** `Authorization: Bearer {token}`

**Request Body:** (`multipart/form-data`)

-   `title` (string, required)
-   `duration` (integer, required)
-   `file` (file, required, audio/mpeg, audio/wav, audio/aac, max:10240KB)
-   `artist_id` (integer, required, exists:artists,id)
-   `album_id` (integer, nullable, exists:albums,id)

**Success Response:**

-   **Code:** 201 Created
-   **Content:** `{"message": "Track uploaded successfully.", "data": { ...track object... }}`

#### Update Track

**Endpoint:** `PUT /api/tracks/{track}`
**Headers:** `Authorization: Bearer {token}`

**Request Body:** (`multipart/form-data`, all fields optional)

-   `title` (string, sometimes)
-   `duration` (integer, sometimes)
-   `file` (file, sometimes, audio/mpeg, audio/wav, audio/aac, max:10240KB)
-   `artist_id` (integer, sometimes, exists:artists,id)
-   `album_id` (integer, nullable, exists:albums,id)

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Track updated successfully.", "data": { ...track object... }}`

#### Delete Track

**Endpoint:** `DELETE /api/tracks/{track}`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Track deleted successfully."}`

---

### Albums

#### Create Album

**Endpoint:** `POST /api/albums`
**Headers:** `Authorization: Bearer {token}`

**Request Body:** (`multipart/form-data`)

-   `title` (string, required)
-   `release_date` (date, required)
-   `cover_image` (file, required, image, max:2048KB)
-   `artist_id` (integer, required, exists:artists,id)

**Success Response:**

-   **Code:** 201 Created
-   **Content:** `{"message": "Album created successfully.", "data": { ...album object... }}`

#### Update Album

**Endpoint:** `PUT /api/albums/{album}`
**Headers:** `Authorization: Bearer {token}`

**Request Body:** (`multipart/form-data`, all fields optional)

-   `title` (string, sometimes)
-   `release_date` (date, sometimes)
-   `cover_image` (file, sometimes, image, max:2048KB)
-   `artist_id` (integer, sometimes, exists:artists,id)

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Album updated successfully.", "data": { ...album object... }}`

#### Delete Album

**Endpoint:** `DELETE /api/albums/{album}`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Album deleted successfully."}`

---

### Artists

#### Create Artist

**Endpoint:** `POST /api/artists`
**Headers:** `Authorization: Bearer {token}`

**Request Body:** (`multipart/form-data`)

-   `name` (string, required)
-   `bio` (string, nullable)
-   `profile_image` (file, required, image, max:2048KB)

**Success Response:**

-   **Code:** 201 Created
-   **Content:** `{"message": "Artist created successfully.", "data": { ...artist object... }}`

#### Update Artist

**Endpoint:** `PUT /api/artists/{artist}`
**Headers:** `Authorization: Bearer {token}`

**Request Body:** (`multipart/form-data`, all fields optional)

-   `name` (string, sometimes)
-   `bio` (string, nullable)
-   `profile_image` (file, sometimes, image, max:2048KB)

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Artist updated successfully.", "data": { ...artist object... }}`

#### Delete Artist

**Endpoint:** `DELETE /api/artists/{artist}`
**Headers:** `Authorization: Bearer {token}`

**Success Response:**

-   **Code:** 200 OK
-   **Content:** `{"message": "Artist deleted successfully."}`

---

## Error Responses

The API may return the following HTTP status codes:

| Status Code | Description                                      |
| ----------- | ------------------------------------------------ |
| 200         | OK - Request succeeded                           |
| 201         | Created - Resource created successfully          |
| 400         | Bad Request - Invalid request parameters         |
| 401         | Unauthorized - Authentication required or failed |
| 403         | Forbidden - Authenticated but not authorized     |
| 404         | Not Found - Resource not found                   |
| 422         | Unprocessable Entity - Validation failed         |
| 500         | Internal Server Error - Server error             |

Validation errors return a 422 status with details:

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field_name": ["The error message for this field."]
    }
}
```

---

## Rate Limiting

The API implements rate limiting to prevent abuse. By default, endpoints are limited to 60 requests per minute per user. Exceeding this limit will result in a `429 Too Many Requests` response.

---

## Pagination

Currently, list endpoints return all records. Future versions may implement pagination for better performance with large datasets.

```

This documentation is now ready to be added to your GitHub repository. It provides clear instructions for any developer who wants to use your API.
```
