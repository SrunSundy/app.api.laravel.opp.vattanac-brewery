/**
 * @apiDefine MissingHeader
 *
 * @apiError (4xx) {400} MissingHeader  The header is missing.
 *
 * @apiErrorExample {json} 400 (MissingHeader):
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
 * @apiError (4xx) {401} AuthorizationInvalid  The dynamic token is invalid or expired.
 *
 * @apiErrorExample {json} 401 (AuthorizationInvalid):
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
 * @apiErrorExample {json} 404 (NotFound):
 HTTP/1.1 404 Not Found
 {
   "success": false,
   "message": {
        "resp_msg": "record not found!"
   }
 }
 *
 */

/**
 * @apiDefine ErrorValidation
 *
 * @apiError (4xx) {422} ErrorValidation validation of required, format, min, max, ....
 *
 * @apiErrorExample {json} 422 (ErrorValidation):
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
 * @apiErrorExample {json} 500 (InternalSeverError):
 HTTP/1.1 500 Error In Server Request
 {
    "success": false,
    "message": "Server Error"
 }
 *
 */
