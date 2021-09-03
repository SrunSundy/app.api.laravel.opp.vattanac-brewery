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
 * @apiDefine AuthorizationInvalid
 *
 * @apiError (4xx) {401} Authorization Invalid  The dynamic token is invalid or expired.
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
 * @apiDefine HeaderInvalid
 *
 * @apiError (4xx) {403} HeaderInvalid  The header is invalid.
 *
 * @apiErrorExample {json} 403 (Header Invalid):
 HTTP/1.1 403 Forbidden
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
    "message": "record not found!"
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
