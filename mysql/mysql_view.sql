/*
 view_comment 视图，供前台查询所用，不允许添加、修改、删除
 引用表ecm_order_goods、ecm_order和virtual_order
 详细说明请看svn:3710/蓝景商城/分阶段/评论系统/商城评论系统数据结构.wps
 liangxifeng 2014-01-17
 */
CREATE VIEW ecm_view_order_comment
	(comment_id,goods_id,type,comment,comment_add_time,reply_content,reply_time,goods_count,note,order_add_time,user_name,user_id,goods_name) 
    AS SELECT ecm_order_goods.rec_id,
              ecm_order_goods.goods_id,
              0,
              ecm_order_goods.comment,
              FROM_UNIXTIME(ecm_order.add_time),
              0,0,
              ecm_order_goods.quantity,
              0,
              FROM_UNIXTIME(ecm_order.add_time),
              ecm_order.buyer_name,
              ecm_order.buyer_id,
              ecm_order_goods.goods_name 
    FROM ecm_order LEFT JOIN ecm_order_goods ON ecm_order.order_id=ecm_order_goods.order_id 
    WHERE ecm_order.status IN(20,30,40)   
    AND ecm_order_goods.is_valid=1 
    UNION ALL
	SELECT ecm_virtual_order.virtual_goods_id,
           ecm_virtual_order.goods_id,
           1,
           ecm_virtual_order.comment_content,
           ecm_virtual_order.comment_add_time,
           ecm_virtual_order.reply_content,
           ecm_virtual_order.reply_add_time,
           ecm_virtual_order.goods_count,
           ecm_virtual_order.note,
           ecm_virtual_order.add_time,
           ecm_virtual_order.virtual_user_name,
           ecm_virtual_order.virtual_user_id,
           ecm_virtual_order.goods_name 
    FROM ecm_virtual_order 
    WHERE ecm_virtual_order.check=1;


/*
 * 在售商品视图
 * 视图中字段来自于商品主表product, 在售商品表offer,和特价商品表sale_onprice，三表关联查询所得
 * 字段说明请查看对应表结构 
 * 查询条件说明：
 *   s.sale_status 　= 2 　特价审核通过
 *   s.offer_type 　　= 1  标准特价商品
 *   s.sale_isClose = 0 　特价未关闭
 *   o.offer_verify　=　2  在售
 *   s.sale_sDate <= curdate() AND s.sale_eDate >= curdate()  当前日期在特价时间范围内
 */
CREATE VIEW product_view AS  
SELECT o.offer_id,
       p.product_id,o.offer_price,p.product_name,p.product_typeid,p.product_model,p.product_specification,
       IFNULL(s.sale_price,0) as sale_price
FROM offer o  
INNER JOIN product p ON o.offer_proid = p.product_id
LEFT JOIN sale_oneprice s ON p.product_id = s.product_id 
        AND s.sale_status = 2 
        AND s.offer_type = 1 
        AND s.sale_isClose = 0 
        AND s.sale_sDate <= curdate() AND s.sale_eDate >= curdate()  
WHERE o.offer_verify = 2;
