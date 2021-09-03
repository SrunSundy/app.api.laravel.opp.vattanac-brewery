/**
 * @apiDefine AuthorizationHeader
 *
 * @apiHeader {string} Authorization    Authorize token for requesting API.
 */

/**
 * @apiDefine AuthHeader
 *
 * @apiHeader {string} Auth             Access token from user login.
 */

/**
 * @apiDefine PostHeaderWithoutAuth
 *
 * @apiHeader {string} Authorization    Authorize token for requesting API.
 * @apiHeader {string} Content-Type     `application/x-www-form-urlencoded`
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Locale=en         locale language for response. `en` || `km`
 * @apiHeader {boolean} Debug            1 or 0. To debug timestamp
 */

/**
 * @apiDefine PostHeader
 *
 * @apiHeader {string} Authorization    Authorize token for requesting API.
 * @apiHeader {string} Auth             Access token from user login.
 * @apiHeader {string} Content-Type     `application/x-www-form-urlencoded`
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Locale=en         locale language for response. `en` || `km`
 * @apiHeader {boolean} Debug            1 or 0. To debug timestamp
 */


/**
 * @apiDefine GetHeader
 *
 * @apiHeader {string} Authorization    Authorize token for requesting API.
 * @apiHeader {string} Auth             Access token from user login.
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Locale=en         locale language for response. `en` || `km`
 * @apiHeader {boolean} Debug            1 or 0. To debug timestamp
 */

/**
 * @apiDefine GetHeaderWithoutAuth
 *
 * @apiHeader {string} Authorization    Authorize token for requesting API.
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Locale=en         locale language for response. `en` || `km`
 * @apiHeader {boolean} Debug            1 or 0. To debug timestamp
 */
