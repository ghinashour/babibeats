erDiagram
USERS {
int id PK
string name
string email
}
ARTISTS {
int id PK
string name
text bio
}
ALBUMS {
int id PK
int artist_id FK
string title
date released_at
}
TRACKS {
int id PK
int album_id FK
int artist_id FK
string title
int duration_seconds
}
PLAYLISTS {
int id PK
int user_id FK
string name
}
PLAYLIST_TRACKS {
int playlist_id FK
int track_id FK
int position
}
FAVORITES {
int id PK
int user_id FK
int favoritable_id
string favoritable_type
}
LISTENING_HISTORY {
int id PK
int user_id FK
int track_id FK
timestamp played_at
}

    USERS ||--o{ PLAYLISTS : creates
    ARTISTS ||--o{ ALBUMS : releases
    ALBUMS ||--o{ TRACKS : contains
    PLAYLISTS ||--o{ PLAYLIST_TRACKS : contains
    TRACKS ||--o{ PLAYLIST_TRACKS : included_in
    USERS ||--o{ FAVORITES : makes
    USERS ||--o{ LISTENING_HISTORY : has
