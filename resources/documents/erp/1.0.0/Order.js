/**
 * @api {Post} /v1/erp/order/status/update 1. Update order status
 * @apiVersion 1.0.0
 * @apiName Update order status
 * @apiGroup Order
 *
 * @apiUse PostHeader
 * 
 * @apiParam {string}           order_number             The order number which get from OPP
 * @apiParam {int=0,1,2}        order_status             The status of order to update. `0` => Pending, `1` => Complete, `2` => Cancel
 *
 * @apiExample {curl} Request usage:
 {
    "order_number" : "SO20210800010",
    "order_status" : 1
 }
 *
 * @apiSuccessExample  Response (example):
 HTTP/1.1 200 Success Request
 {
    "success": true,
    "message": "Success",
    "data": {
        "order_number" : "SO20210800010"
    }
 }
 *
 * @apiUse MissingHeader
 * @apiUse AuthorizationInvalid
 * @apiUse HeaderInvalid
 * @apiUse NotFound
 * @apiUse ErrorValidation
 * @apiUse ServerServerError
 */
