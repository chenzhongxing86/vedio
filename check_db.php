<?php
require_once 'thinkphp/start.php';

// 测试数据库连接
try {
    $db = Db::name('admins');
    echo "数据库连接成功\n";
    
    // 获取表结构
    $result = Db::query('DESCRIBE admins');
    echo "\n表结构：\n";
    foreach ($result as $row) {
        echo "{$row['Field']} - {$row['Type']} - {$row['Null']} - {$row['Default']}\n";
    }
    
    // 测试插入数据
    echo "\n测试插入状态为0的数据：\n";
    $testData = [
        'username' => 'test_user',
        'password' => md5('test_user123'),
        'gid' => 1,
        'truename' => '测试用户',
        'status' => 0,
        'add_time' => time()
    ];
    
    $insertResult = Db::name('admins')->insert($testData);
    echo "插入结果：" . ($insertResult ? '成功' : '失败') . "\n";
    
    // 测试更新数据
    echo "\n测试更新状态为0的数据：\n";
    $updateResult = Db::name('admins')->where(['username' => 'test_user'])->update(['status' => 0]);
    echo "更新结果：" . ($updateResult ? '成功' : '失败') . "\n";
    
    // 清理测试数据
    Db::name('admins')->where(['username' => 'test_user'])->delete();
    
} catch (Exception $e) {
    echo "错误：" . $e->getMessage() . "\n";
}
?>