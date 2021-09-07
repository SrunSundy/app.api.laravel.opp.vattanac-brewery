/**
 * @apiDefine PostHeader
 *
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Content-Type     `application/json`
 * @apiHeader {string} Authorization    `Bearer ${dynamic_token}`. `dynamic_token` get from combination of `${Access-Token}[-]${Current Timestamp}` using `AES` encryption with `CBC` mode.
 */

/**
 * @apiDefine PostHeaderWithoutAuth
 *
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Content-Type     `application/json`
 */

/**
 * @apiDefine GetHeader
 *
 * @apiHeader {string} Accept           `application/json`
 * @apiHeader {string} Authorization    `Bearer ${dynamic_token}`. `dynamic_token` get from combination of `${Access-Token}[-]${Current Timestamp}` using `AES` encryption with `CBC` mode.
 */

/**
 * @apiDefine GetHeaderWithoutAuth
 *
 * @apiHeader {string} Accept           `application/json`
 */