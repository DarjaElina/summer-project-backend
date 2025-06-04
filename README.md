# This is our summer project backend

<mark><b>SQL:</b></mark> There are the list of SQL commands we have used in our SQL Database. All the sql commands will be in sqlCommands.sql file in the root directory of this project.

## 🌐 **API Routes**

### 🔐 **User Authentication**

| Endpoint                           | Method | Description                        |
| ---------------------------------- | ------ | ---------------------------------- |
| `http://127.0.0.1:8000/api/signup` | POST   | ✨ Create a new user account       |
| `http://127.0.0.1:8000/api/login`  | POST   | 🔑 Login with existing credentials |
| `http://127.0.0.1:8000/api/logout` | POST   | 🚪 Logout current user             |

### 🎪 **Events Management**

| Endpoint                                | Method | Description              |
| --------------------------------------- | ------ | ------------------------ |
| `http://127.0.0.1:8000/api/events`      | POST   | 🆕 Create new event      |
| `http://127.0.0.1:8000/api/events`      | GET    | 📋 Get all events        |
| `http://127.0.0.1:8000/api/events/{id}` | GET    | 🔍 Get specific event    |
| `http://127.0.0.1:8000/api/events/{id}` | PUT    | ✏️ Update existing event |
| `http://127.0.0.1:8000/api/events/{id}` | DELETE | 🗑️ Delete an event       |

---

## 🛠️ **Usage Examples**

### 🔄 Updating an Event

```http
PUT http://127.0.0.1:8000/api/events/1
Content-Type: multipart/form-data

{
    "title": "Updated Tech Conference",
    "name": "Name of the Event",
    "description": "New location and time!",
    "image": [upload file],
    "lat": 34.052235,
    "lon": -118.243683
}
```
