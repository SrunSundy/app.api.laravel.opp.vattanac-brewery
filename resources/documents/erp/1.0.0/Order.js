/**
 * @api {Post} /v1/erp/order/list/outlet/{outlet_id} 1. List order by outlet
 * @apiVersion 1.0.0
 * @apiName List order by outlet
 * @apiGroup Order
 *
 * @apiUse GetHeader
 * 
 * @apiParam {integer} outlet_id          The outlet id to list the order (Will get sample from OPP)
 * @apiUse DefaultListParameter
 *
 * @apiSuccessExample  Response (example):
 HTTP/1.1 200 Success Request
 {
    "success": true,
    "message": "",
    "data": {
        "list": [
            {
                "id": 38,
                "order_number": "SO20210800038",
                "outlet_name": "Sokahkrom",
                "agent_name": "Sophanith",
                "coupon_code": "",
                "sub_total": 20.6,
                "percent_off": 0,
                "amount_off": 0,
                "total": 20.6,
                "is_urgent": 0,
                "order_status": "Pending"
            }
        ],
        "total": 20
    }
 }
 *
 * @apiUse MissingHeader
 * @apiUse AuthorizationInvalid
 * @apiUse HeaderInvalid
 * @apiUse ErrorValidation
 * @apiUse ServerServerError
 */

/**
 * @api {Post} /v1/erp/order/{order_number}/outlet/{outlet_id} 2. View order by outlet
 * @apiVersion 1.0.0
 * @apiName View order by outlet
 * @apiGroup Order
 *
 * @apiUse GetHeader
 * 
 * @apiParam {string}  order_number       The order number which get from order list
 * @apiParam {integer} outlet_id          The outlet id which proceed the order
 *
 * @apiSuccessExample  Response (example):
 HTTP/1.1 200 Success Request
 {
    "success": true,
    "message": "",
    "data": {
        "id": 38,
        "order_number": "SO20210800038",
        "outlet_name": "Sokahkrom",
        "agent_name": "Sophanith",
        "coupon_code": "",
        "sub_total": 20.6,
        "percent_off": 0,
        "amount_off": 0,
        "total": 20.6,
        "is_urgent": 0,
        "order_status": "Pending"
    }
 }
 *
 * @apiUse MissingHeader
 * @apiUse AuthorizationInvalid
 * @apiUse HeaderInvalid
 * @apiUse ErrorValidation
 * @apiUse ServerServerError
 */

/**
 * @api {Post} /v1/erp/order/status/update 3. Update order status
 * @apiVersion 1.0.0
 * @apiName Update order status
 * @apiGroup Order
 *
 * @apiUse PostHeader
 * 
 * @apiParam {string}                     order_number             The order number which get from OPP
 * @apiParam {integer=202,200,499}        order_status             The status of order to update. `202` => Pending, `200` => Complete, `499` => Cancel
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