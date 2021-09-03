/**
 * @apiDefine DefaultListParameter
 *
 * @apiParam {string}  search      Key search resource
 * @apiParam {integer} offset      Offset of list resource
 * @apiParam {integer} limit       Limit of list resource
 * @apiParam {string} sort         Sort of list resource. eg. sort=asc|desc
 * @apiParam {string} order        Ordering field to sort. eg. order=updated_at
 */

/**
 * @apiDefine DefaultListParameterWithoutSort
 *
 * @apiParam {string}  search      Key search resource
 * @apiParam {integer} offset      Offset of list resource
 * @apiParam {integer} limit       Limit of list resource
 */

/**
 * @apiDefine ActiveStatusParameter
 *
 * @apiParam {boolean}  is_enable      publish/active status
 */


/**
 * @apiDefine SequenceOrderParameter
 *
 * @apiParam {integer}  sequence_order      sequence order
 */

/**
 * @apiDefine GroupChatCreateUpdateParameter
 *
 * @apiParam {boolean}  [is_enable]             active status
 * @apiParam {boolean}  [is_public]             public status
 * @apiParam {array}    participant_ids         user ids that add to group
 * @apiParam {array}    agency_ids              agent ids that add to group
 * @apiParam {array}    translations            translations data
 * @apiParam {string}   translations.lang            translations language code. `en` or `km`
 * @apiParam {string}   translations.name            translations name
 * @apiParam {base64}   image                   image base64 string
 */

/**
 * @apiDefine DefaultCreateParameter
 *
 * @apiParam {boolean}  [is_enable]                         active status
 * @apiParam {boolean}  [is_public]                         public status
 * @apiParam {boolean}  [is_send_notification]              send notification or not
 * @apiParam {string}   [agent_codes]                       required when is_public=false
 * @apiParam {array}    categories                          categories id
 *
 * @apiParam {array}    translations                        translations data
 * @apiParam {string}   translations.lang                   translations language code. `en` or `km`
 * @apiParam {string}   translations.title                  translations title
 *
 * @apiParam {array}    contents                            contents
 * @apiParam {string}   contents.lang                   content language code. `en` or `km`
 * @apiParam {string}   contents.type                   content type. `text` or `image`
 * @apiParam {string}   contents.content                content data
 *
 * @apiParam {array}    attachments                         attachments
 * @apiParam {base64}   attachments.file                    base64 string
 * @apiParam {string}   attachments.file_name               file name
 * @apiParam {string}   attachments.file_ext                file extension
 */


/**
 * @apiDefine DefaultCreateCategoryParameter
 *
 * @apiParam {boolean}  [is_enable]                         active status
 * @apiParam {integer}  [sequence_order]                    sequence order
 *
 * @apiParam {array}    translations                        translations data
 * @apiParam {string}   translations.lang                   translations language code. `en` or `km`
 * @apiParam {string}   translations.title                  translations title
 */


/**
 * @apiDefine AttachmentYoutubeParameter
 *
 * @apiParam {base64}   attachments.youtube_url             youtube url
 * @apiParam {string}   attachments.youtube_title           youtube title
 */
