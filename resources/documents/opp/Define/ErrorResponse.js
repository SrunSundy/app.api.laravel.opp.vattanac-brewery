/**
 * @apiDefine MissingHeader
 *
 * @apiError (4xx) {400} MissingHeader  The header is missing.
 *
 * @apiErrorExample {json} 400 (Missing Header):
 HTTP/1.1 400 Bad Request
 {
    "success": false,
    "message": "The Grant-Type, Client-Id, Client-Secret, Authorization field is required."
 }
 *
 */

/**
 * @apiDefine InvalidCredential
 *
 * @apiError (4xx) {400} Invalid Credential  The Phone Number or Password is incorrect.
 *
 * @apiErrorExample {json} 400 (InvalidCredential):
 HTTP/1.1 400 Bad Request
 {
    "success": false,
    "message": "The Phone Number or Password is incorrect."
 }
 *
 */

/**
 * @apiDefine AuthorizationEncryptionInvalid
 *
 * @apiError (4xx) {403} AuthorizationEncryptionInvalid  The authorization token encytion is invalid.
 *
 * @apiErrorExample {json} 403 (Authorization Encryption Invalid):
 HTTP/1.1 403 Forbidden
 {
    "success": false,
    "message": "Unauthorized request",
    "code": 100
 }
 *
 */

/**
 * @apiDefine AuthorizationExceedLimitTime
 *
 * @apiError (4xx) {403} AuthorizationExceedLimitTime  The authorization token is exceed the limit time.
 *
 * @apiErrorExample {json} 403 (Authorization Exceed Limit Time):
 HTTP/1.1 403 Forbidden
 {
    "success": false,
    "message": "Unauthorized request",
    "code": 101
 }
 *
 */

/**
 * @apiDefine AuthorizationInvalid
 *
 * @apiError (4xx) {401} AuthorizationInvalid  The authorization token is invalid or expired.
 *
 * @apiErrorExample {json} 401 (Authorization Invalid):
 HTTP/1.1 401 Unauthorized
 {
    "success": false,
    "message": "Unauthorized request"
 }
 *
 */

/**
 * @apiDefine Forbidden
 *
 * @apiError (4xx) {403} Forbidden  resource is forbidden to access
 *
 * @apiErrorExample {json} 403 (Forbidden):
 HTTP/1.1 403 Forbidden
 {
    "success": false,
    "message": "You are not allowed to update this :attribute."
 }
 *
 */

/**
 * @apiDefine NotFound
 *
 * @apiError (4xx) {404} NotFound  resource is not found
 *
 * @apiErrorExample {json} 404 (Not Found):
 HTTP/1.1 404 Not Found
 {
    "success": false,
    "message": "Not Found"
 }
 *
 */

/**
 * @apiDefine MethodNotAllowed
 *
 * @apiError (4xx) {405} MethodNotAllowed  Use wrong method
 *
 * @apiErrorExample {json} 405 (Method Not Allowed):
 HTTP/1.1 405 Method Not Allowed
 {
    "success": false,
    "message": "Method Not Allowed"
 }
 *
 */

/**
 * @apiDefine ErrorValidation
 *
 * @apiError (4xx) {422} ErrorValidation validation of required, format, min, max, ....
 *
 * @apiErrorExample {json} 422 (Error Validation):
 HTTP/1.1 422 Unauthorized
 {
    "success": false,
    "message": {
        "field": [
            "validation message"
        ]
    }
 }
 *
 */

/**
 * @apiDefine ServerServerError
 *
 * @apiError (5xx) {500} InternalSeverError internal server error
 *
 * @apiErrorExample {json} 500 (Internal Sever Error):
 HTTP/1.1 500 Error In Server Request
 {
    "success": false,
    "message": "Server Error"
 }
 *
 */
