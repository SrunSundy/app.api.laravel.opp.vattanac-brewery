/**
 * @apiDefine DefaultResponse
 *
 * @apiSuccess (200) {boolean}      success                 success status
 * @apiSuccess (200) {object}       data                    response data
 *
 */

/**
 * @apiDefine DefaultGetListResponse
 *
 * @apiSuccess (200) {boolean}      success                 success status
 * @apiSuccess (200) {object}       data                    response data
 * @apiSuccess (200) {array}        data.list                    list of resources
 * @apiSuccess (200) {number}       data.total                   total of resources
 *
 */

/**
 * @apiDefine DefaultPostSuccessResponse
 *
 * @apiSuccess (200) {boolean}      success                 success status
 * @apiSuccess (200) {string}       data                    response message
 *
 */

/**
 * @apiDefine MediaResponse
 *
 * @apiSuccess (200) {object}       data.list.media              image
 * @apiSuccess (200) {string}       data.list.media.file_url              image url
 * @apiSuccess (200) {string}       data.list.media.file_name             image name
 * @apiSuccess (200) {string}       data.list.media.file_type             image type
 * @apiSuccess (200) {string}       data.list.media.size                  image size
 */

/**
 * @apiDefine DefaultMediaResponse
 *
 * @apiSuccess (200) {object}       data.media              image
 * @apiSuccess (200) {string}       data.media.file_url              image url
 * @apiSuccess (200) {string}       data.media.file_name             image name
 * @apiSuccess (200) {string}       data.media.file_type             image type
 * @apiSuccess (200) {string}       data.media.size                  image size
 */

/**
 * @apiDefine DefaultCreateAndUpdateListResponse
 *
 * @apiSuccess (200) {integer}      data.list.created_by          user id who created record
 * @apiSuccess (200) {integer}      data.list.updated_by          user id who updated record
 * @apiSuccess (200) {datetime}     data.list.created_at          created date
 * @apiSuccess (200) {datetime}     data.list.updated_at          updated date
 *
 */
/**
 * @apiDefine DefaultCreateAndUpdateResponse
 *
 * @apiSuccess (200) {integer}      data.created_by          user id who d record
 * @apiSuccess (200) {integer}      data.updated_by          user id who updated record
 * @apiSuccess (200) {datetime}     data.created_at          created date
 * @apiSuccess (200) {datetime}     data.updated_at          updated date
 *
 */

/**
 * @apiDefine DefaultCreatorAndUpdaterListResponse
 *
 * @apiSuccess (200) {integer}      data.list.created_by          user id who created record
 * @apiSuccess (200) {integer}      data.list.updated_by          user id who updated record
 */

/**
 * @apiDefine TranslationListResponse
 *
 * @apiSuccess (200) {object}     data.list.translation               resource translation
 * @apiSuccess (200) {string}     data.list.translation.name          resource translation name
 */

/**
 * @apiDefine DefaultAttachmentsListResponse
 *
 * @apiSuccess (200) {array}     data.list.attachments               resource attachments
 * @apiSuccess (200) {string}    data.list.attachments.file_url               attachment file url
 * @apiSuccess (200) {string}    data.list.attachments.file_name              attachment file name
 * @apiSuccess (200) {string}    data.list.attachments.file_type              attachment file type
 * @apiSuccess (200) {string}    data.list.attachments.size                   attachment file size
 */


/**
 * @apiDefine DefaultAttachmentsResponse
 *
 * @apiSuccess (200) {array}     data.attachments               resource attachments
 * @apiSuccess (200) {string}    data.attachments.file_url               attachment file url
 * @apiSuccess (200) {string}    data.attachments.file_name              attachment file name
 * @apiSuccess (200) {string}    data.attachments.file_type              attachment file type
 * @apiSuccess (200) {string}    data.attachments.size                   attachment file size
 */

/**
 * @apiDefine DefaultCategoriesListResponse
 *
 * @apiSuccess (200) {array}     data.list.categories               resource categories
 * @apiSuccess (200) {string}    data.list.categories.id                   category id
 * @apiSuccess (200) {object}    data.list.categories.translation          category translation
 * @apiSuccess (200) {string}    data.list.categories.translation.title          category translation title
 */

/**
 * @apiDefine DefaultCategoriesResponse
 *
 * @apiSuccess (200) {array}     data.categories               resource categories
 * @apiSuccess (200) {string}    data.categories.id                   category id
 * @apiSuccess (200) {object}    data.categories.translation          category translation
 * @apiSuccess (200) {string}    data.categories.translation.title          category translation title
 */

/**
 * @apiDefine DefaultTranslationListResponse
 *
 * @apiSuccess (200) {object}     data.list.translation                resource translation
 * @apiSuccess (200) {string}     data.list.translation.title          resource translation title
 */

/**
 * @apiDefine DefaultTranslationResponse
 *
 * @apiSuccess (200) {object}     data.translation                resource translation
 * @apiSuccess (200) {string}     data.translation.title          resource translation title
 */

/**
 * @apiDefine DefaultShowTranslationResponse
 *
 * @apiSuccess (200) {array}     data.languages               resource available language
 * @apiSuccess (200) {string}    data.languages.title               resource language title
 * @apiSuccess (200) {string}    data.languages.code                resource language code
 * @apiSuccess (200) {object}    data.languages.translations                resource translation
 * @apiSuccess (200) {string}    data.languages.translations.title                resource translation title
 */

/**
 * @apiDefine DefaultTranslationResponseWithContent
 *
 * @apiSuccess (200) {array}     data.languages               resource available language
 * @apiSuccess (200) {string}    data.languages.title               resource language title
 * @apiSuccess (200) {string}    data.languages.code                resource language code
 * @apiSuccess (200) {object}    data.languages.translations                resource translation
 * @apiSuccess (200) {object}    data.languages.translations.title                resource translation title
 * @apiSuccess (200) {array}     data.languages.contents             resource dynamic content
 * @apiSuccess (200) {string}    data.languages.contents.content             dynamic data. can be object of media when type is image
 * @apiSuccess (200) {string}    data.languages.contents.type                dynamic type. `text` or `image`
 */
