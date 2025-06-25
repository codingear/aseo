# API de Actividades de Usuario

Esta API permite consultar las actividades asignadas a los usuarios por día de la semana.

## Endpoints Disponibles

### Base URL
```
/api/users/{username}
```

### 1. Obtener información del usuario
```
GET /api/users/{username}
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Usuario Ejemplo",
        "username": "usuario123",
        "email": "usuario@ejemplo.com",
        "user_activities": [...]
    },
    "message": "User retrieved successfully"
}
```

### 2. Obtener actividades del usuario para un día específico
```
GET /api/users/{username}/activities/weekday/{weekday}
```

**Parámetros:**
- `username`: El nombre de usuario del usuario
- `weekday`: Puede ser el número del día (1-7, donde 1=Lunes, 7=Domingo) o el nombre del día

**Ejemplos:**
- `/api/users/usuario123/activities/weekday/1` (Lunes)
- `/api/users/usuario123/activities/weekday/lunes`

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Usuario Ejemplo",
            "username": "usuario123",
            "email": "usuario@ejemplo.com"
        },
        "weekday": {
            "id": 1,
            "name": "Lunes",
            "day_number": 1
        },
        "activities": [
            {
                "id": 1,
                "user_id": 1,
                "activity_id": 1,
                "weekday_id": 1,
                "is_completed": false,
                "assigned_date": "2025-06-25",
                "activity": {
                    "id": 1,
                    "name": "Ejercicio matutino",
                    "description": "30 minutos de ejercicio",
                    "is_active": true
                },
                "weekday": {
                    "id": 1,
                    "name": "Lunes",
                    "day_number": 1
                }
            }
        ]
    },
    "message": "User activities retrieved successfully for Lunes"
}
```

### 3. Obtener actividades del usuario para hoy
```
GET /api/users/{username}/activities/today
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Usuario Ejemplo",
            "username": "usuario123",
            "email": "usuario@ejemplo.com"
        },
        "today": {
            "date": "2025-06-25",
            "day_name": "Wednesday",
            "weekday": {
                "id": 3,
                "name": "Miércoles",
                "day_number": 3
            }
        },
        "activities": [...]
    },
    "message": "Today activities retrieved successfully"
}
```

### 4. Obtener todas las actividades del usuario agrupadas por día
```
GET /api/users/{username}/activities
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Usuario Ejemplo",
            "username": "usuario123",
            "email": "usuario@ejemplo.com"
        },
        "activities_by_weekday": {
            "Lunes": [...],
            "Martes": [...],
            "Miércoles": [...]
        }
    },
    "message": "All user activities retrieved successfully"
}
```

## Códigos de Respuesta

- `200`: Éxito
- `404`: Usuario o día de la semana no encontrado
- `500`: Error interno del servidor

## Ejemplos de Uso

### Con curl:
```bash
# Obtener actividades de hoy para el usuario usuario123
curl -X GET "http://localhost/api/users/usuario123/activities/today"

# Obtener actividades del lunes para el usuario usuario123
curl -X GET "http://localhost/api/users/usuario123/activities/weekday/1"

# Obtener actividades del martes por nombre
curl -X GET "http://localhost/api/users/usuario123/activities/weekday/martes"
```

## Notas Importantes

1. El sistema detecta automáticamente el día actual usando `now()->dayOfWeek`
2. Los días de la semana se numeran del 1 al 7 (Lunes=1, Domingo=7)
3. Se pueden buscar días tanto por número como por nombre (parcial)
4. Todas las respuestas incluyen información completa de las actividades y días de la semana
