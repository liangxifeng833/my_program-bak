--
-- 存储过程-获取软装券
-- 语法说明：http://bbs.phpchina.com/home.php?mod=space&uid=870297&do=blog&id=194905
--
-- @author: Liangxifeng
-- @date  : 2015-03-08
-- @param : varchar [oid]     - 微信用户唯一标识，从微信服务器获取
-- @param : varchar [nickName]- 微信用户昵称
-- @return: 返回结果如果是return_number，代表成功抢购，如果是return_error代表抢购失败，事务已回滚
-- @php调用: mysql_fetch_assoc(mysql_query("CALL get_rzq('liangxifeng','梁胖')"));
--
DELIMITER $$ 
DROP 	PROCEDURE IF EXISTS `get_rzq`$$
CREATE PROCEDURE `get_rzq` (in oid varchar(50), in nickName varchar(50) CHARACTER SET utf8) -- character set utf8 很重要，否则中文会乱码

label_pro:BEGIN                                 -- label_pro自定义的，当在以下程序中需要exit的时候，可以 LEAVE label_pro;
declare id int default 0;                       -- 软装券表主键id 
declare userid int default 0;                   -- 微信用户表主键id
declare row_count int default 0;                -- 操作sql的时候影响行数
declare return_number varchar(50) default '';   -- 抢购成功返回的券编号
declare sign int default 1;                     -- 回滚标识符，0：回滚
declare return_error int default 1;             -- 回滚后返回信息，如果是1


START TRANSACTION;  
SELECT rzq_id,rzq_number INTO id,return_number  FROM ecm_tmp_wechat_rzq WHERE rzq_status=0 ORDER BY rzq_id ASC LIMIT 1 FOR UPDATE;
UPDATE ecm_tmp_wechat_rzq SET user_openid=oid,rzq_status=1,rzq_update_time=now() WHERE rzq_id=id;
set row_count = 0;	
SELECT ROW_COUNT() INTO row_count;

if row_count > 0 then
    SELECT user_id INTO userid FROM ecm_tmp_wechat_rzq_user WHERE user_openid=oid; 
    set row_count=0;
    set names utf8;
    -- 判断该用户今天是否成功抢购过券，如果没有則新加入到用户表一条记录，否则修改购买数量
    if userid = 0 then		
        INSERT INTO ecm_tmp_wechat_rzq_user (`user_openid`,`user_nickname`,`user_order_count`,`user_add_time`) VALUES (oid,nickName,1,now());
        SELECT row_count() INTO row_count;
        if row_count != 1 then
            set sign=0;
        end if;
    else
        UPDATE ecm_tmp_wechat_rzq_user SET user_order_count=user_order_count+1 WHERE user_openid=oid;
        SELECT row_count() INTO row_count;
        if row_count <= 0 then
            set sign=0;
        end if;
    end if;
    
    -- 抢购成功，提交事务，返回编号
    if sign=1 then 
        COMMIT;
        SELECT return_number;
    else
        ROLLBACK;
        SELECT return_error;
    end if;
else
    ROLLBACK;
    SELECT return_error;
end if;
END $$
DELIMITER ;
