/**
 * @api {Post} /api/v1/erp/order/status/update 1. Update order status
 * @apiVersion 1.0.0
 * @apiName Update order status
 * @apiGroup Order
 *
 * @apiUse PostHeader
 * 
 * @apiParam {String}   order_number             Order Number
 * @apiParam {Int}      order_status             Order Status
 *
 * @apiSuccessExample  Response (example):
 HTTP/1.1 200 Success Request
 {
    "success": true,
    "data": {
        "id": 6,
        "booking_period_type": "session",
        "booking_period": "Morning Session",
        "space_category": "Hot Desk",
        "space_name": "City View",
        "space_image_url": "http://api.booking.local/uploads/image/2021/1/724359fc2646d01b79045e9778b57d24.png",
        "start_date": "2020-01-03",
        "end_date": "2020-01-04",
        "start_time": "08:00:00",
        "end_time": "12:00:00",
        "quantity": 2,
        "price": 10,
        "total_price": 20
    }
 }
 *
 * @apiUse AuthorizationInvalid
 * @apiUse NotFound
 * @apiUse ServerServerError
 */
