/**
 * @api {Post} /v1/auth/login 1. Login
 * @apiVersion 1.0.0
 * @apiName 1. Login
 * @apiGroup Authentication
 *
 * @apiUse PostHeaderWithoutAuth
 *
 * @apiParam {String} phone_number      User phone number to login
 * @apiParam {String} password          User password to login
 *
 * @apiExample {curl} Request usage:
 {
    "phone_number" : "086457447",
    "password" : "123456"
 }
 *
 * @apiSuccessExample  Response (example):
 HTTP/1.1 200 Success Request
 {
    "success": true,
    "message": "",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkub3BwLmxvY2FsXC9hcGlcL3YxXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYzMDkxODg3MiwiZXhwIjoxNjMwOTIyNDcyLCJuYmYiOjE2MzA5MTg4NzIsImp0aSI6InZIaEREbDM2enI5dndIcEMiLCJzdWIiOjEsInBydiI6IjhjYzU2OWQ0MWYwYmZjM2EzYjlhMWVjY2E0NWY1N2Y5Y2FiNGUzNWUifQ.5WjKjcbyZixeWKQ3uq4lhrIkQmB18it6_NzZ2Q4kcIk",
        "token_type": "Bearer",
        "expires_in": 3600
    }
 }
 *
 * @apiUse InvalidCredential
 * @apiUse NotFound
 * @apiUse MethodNotAllowed
 * @apiuse ErrorValidation
 * @apiUse ServerServerError
 */

 /**
 * @api {Post} /v1/auth/logout 2. Logout
 * @apiVersion 1.0.0
 * @apiName 2. Logout
 * @apiGroup Authentication
 *
 * @apiUse PostHeader
 *
 * @apiSuccessExample  Response (example):
 HTTP/1.1 200 Success Request
 {
    "success": true,
    "message": "You have been logged out successfully.",
    "data": null
 }
 *
 * @apiUse AuthorizationInvalid
 * @apiUse AuthorizationEncryptionInvalid
 * @apiUse AuthorizationExceedLimitTime
 * @apiUse NotFound
 * @apiUse MethodNotAllowed
 * @apiUse ServerServerError
 */

 /**
 * @api {Post} /v1/auth/refresh 3. Refresh Token
 * @apiVersion 1.0.0
 * @apiName 3. Refresh Token
 * @apiGroup Authentication
 *
 * @apiUse PostHeader
 *
 * @apiSuccessExample  Response (example):
 HTTP/1.1 200 Success Request
 {
    "success": true,
    "message": "",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkub3BwLmxvY2FsXC9hcGlcL3YxXC9hdXRoXC9yZWZyZXNoIiwiaWF0IjoxNjMwOTE3NTQwLCJleHAiOjE2MzA5MjExNjksIm5iZiI6MTYzMDkxNzU2OSwianRpIjoiSFhhS0pGNVJqdTVWUEJoOCIsInN1YiI6MSwicHJ2IjoiOGNjNTY5ZDQxZjBiZmMzYTNiOWExZWNjYTQ1ZjU3ZjljYWI0ZTM1ZSJ9.NVgpfUtoT9m1tglzrNxqTneG4kHORD-lXV2ya5N2v4Y",
        "token_type": "Bearer",
        "expires_in": 3600
    }
 }
 *
 * @apiUse AuthorizationInvalid
 * @apiUse AuthorizationEncryptionInvalid
 * @apiUse AuthorizationExceedLimitTime
 * @apiUse NotFound
 * @apiUse MethodNotAllowed
 * @apiUse ServerServerError
 */
