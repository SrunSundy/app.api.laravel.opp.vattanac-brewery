/**
 * @apiDefine PostHeader
 *
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Content-Type     `application/json`
 * @apiHeader {string} Grant-Type       Grant-Type get from OPP team.
 * @apiHeader {string} Client-Id        Client-Id get from OPP team.
 * @apiHeader {string} Client-Secret    Client-Secret get from OPP team.
 * @apiHeader {string} Authorization    `Bearer ${dynamic_token}`. `dynamic_token` get from combination of `${Clint-Id}-${Client-Secret}-${Current Timestamp}` using `AES` encryption with `CBC` mode.
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