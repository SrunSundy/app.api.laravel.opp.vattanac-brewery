/**
 * @apiDefine TokenExpired
 *
 * @apiError (4xx) {400} TokenExpired Token is expired
 *
 * @apiErrorExample {json} 400 (TokenExpired):
 HTTP/1.1 400 Bad Request
 {
    "success": false,
    "message": "The token is expired."
 }
 */

/**
 * @apiDefine OtpIncorrect
 *
 * @apiError (4xx) {400} OtpIncorrect The Otp is incorrect.
 *
 * @apiErrorExample {json} 400 (OtpIncorrect):
 HTTP/1.1 400 Bad Request
 {
    "success": false,
    "message": "The verify code confirmation does not match."
 }
 */

/**
 * @apiDefine IncorrectUsernamePassword
 *
 * @apiError (4xx) {400} IncorrectUsernamePassword Username or Password is incorrect.
 *
 * @apiErrorExample {json} 400 (IncorrectUsernamePassword):
 HTTP/1.1 400 Bad Request
 {
    "success": false,
    "message": "The username/password is incorrect."
 }
 */

/**
 * @apiDefine AuthorizationInvalid
 *
 * @apiError (4xx) {401} AuthorizationInvalid  authorization token is missing, expire, or invalid.
 *
 * @apiErrorExample {json} 401 (AuthorizationInvalid):
 HTTP/1.1 401 Unauthorized
 {
    "success": false,
    "code": 100,
    "message": "The authorization is invalid."
 }
 *
 */

/**
 * @apiDefine AuthInvalid
 *
 * @apiError (4xx) {401} AuthInvalid  auth token is missing, expire, or invalid.
 *
 * @apiErrorExample {json} 401 (AuthInvalid):
 HTTP/1.1 401 Unauthorized
 {
    "success": false,
    "code": 101,
    "message": "user is unauthorized. The token is invalid."
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
 * @apiError (4xx) {412} ErrorValidation validation of required, format, min, max, ....
 *
 * @apiErrorExample {json} 412 (ErrorValidation):
 HTTP/1.1 401 Unauthorized
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
