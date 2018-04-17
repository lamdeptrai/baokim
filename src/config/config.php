<?php
return array(

    'SANDBOX'   => false,
    'NganLuong' => array(
        'MERCHANT_ID'    => 'merchant',
        'MERCHANT_PASS'  => '1234',
        'RECEIVER'       => 'dev.baokim@bk.vn',
        'URL_WS_SANDBOX' => 'http://beta.nganluong.vn/micro_checkout_api.php?wsdl',
        'URL_WS'         => 'https://www.nganluong.vn/micro_checkout_api.php?wsdl'
    ),
    'BaoKim'    => array(
        //CẤU HÌNH TÀI KHOẢN (Configure account)
        'EMAIL_BUSINESS'     => 'dev.baokim@bk.vn',//Email Bảo kim
        'MERCHANT_ID'        => '647',// Mã website tích hợp
        'SECURE_PASS'        => 'ae543c080ad91c23',
        //Mật khẩu website của khách hàng là : 62890a315059da89
        //Để đảm bảo cho tính bảo mật thông tin khách hàng, mật khẩu này chỉ hiển thị duy nhất một lần. Mong quý khách hay lưu mật khẩu này để sử dụng.
        // Cấu hình tài khoản tích hợp
        'API_USER'           => 'merchant', //API USER,
        'API_PWD'            => '1234',//API PASSWORD
        'PRIVATE_KEY_BAOKIM' => '-----BEGIN PRIVATE KEY-----
        MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDZZBAIQz1UZtVm
        p0Jwv0SnoIkGYdHUs7vzdfXYBs1wvznuLp/SfC/MHzHVQw7urN8qv+ZDxzTMgu2Q
        3FhMOQ+LIoqYNnklm+5EFsE8hz01sZzg+uRBbyNEdcTa39I4X88OFr13KoJC6sBE
        397+5HG1HPjip8a83v8G4/IPcna5/3ydVbJ9ZeMSUXP6ZyKAKay4M22/Wli7PLrm
        1XNR9JgIuQLma74yCGkaXtCJQswjyYAmwDPpz4ZknSGuBYUmwaHMgrDOQsOXFW7/
        7M2KbjenwggAW98f0f97AR2DEq9Eb5r8vzyHURnHGD3/noZxl993lM2foPI3SKBO
        1KpSeXRzAgMBAAECggEANMINBgRTgQVH6xbSkAxLPCdAufTJeMZ56bcKB/h2qVMv
        Wvejv/B1pSM489nHaPM5YeWam35f+PYZc5uWLkF23TxvyEsIEbGLHKktEmR73WkS
        eqNI+/xd4cJ3GOtS2G2gEXpBVwdQ/657JPvz4YZNdjfmyxMOr02rNN/jIg6Uc8Tz
        vbpGdtP49nhqcOUpbKEyUxdDo6TgLVgmLAKkGJVW40kwvU9hTTo6GXledLNtL2kD
        l6gpVWAiT6xlTsD5m74YzsxCSjkh60NdYeUDYwMbv0WWH3kJq6qD063ac3i/i8H+
        B5nGf4KbKg1bBjPLNymUj7RRnKjHr301i2u8LUQYuQKBgQD15YCoa5uHd6DHUXEK
        kejU34Axznr3Gs6LqcisE7t0oQ9hB4s16U9f4DBHDOvnkLb0zkadwdEmwo/D/Tdf
        5c/JEk8q/aO9Wk8uV4Bswnx1OV9uKMzMOZbv/So1DQg1aW1MgvRnj3SiKpDUkNwr
        en4NT9tbH21SmVIO9Da5KpiFRwKBgQDiUrg1hp8EDaeZFTG9DvcwyTTrpD/YT9Wr
        s/NtEnPMjy0NXWcEXwGzx90P+qjJ+J29Hk89QHON6S7o0X2lUIer3uXokc86ce76
        5UIbR6u7R1T6TUNfwqwwNfIbgtFN4+7ybodPNZ5DWslKLqMr5wpwIOr7/U5ih7BH
        JK0cSriddQKBgGXzNZiepOlRrBN3rMqZHFPGJrx/w3PYZXJ6fnz54WrFrD6qhglg
        Jky2As4yiUyFL5XoQFcAGNtdJ4Y24lKcUb4oHTLR3qWPX+zy0ohFSpy/oNVnjSHP
        bskpyeoc8R5UC8EBOpwFWnIx+8JmHSLZspGKXoQ1T3pDn0Yb8uRqyLnZAoGBAKdk
        NwqfvwzobIU0v8ztPLbAmnuOyAndQlP0jJ6nfy5U1yWDZ6Y7/q5RrJcc9aosT76I
        pGLRQKY9SYy5JQ0YOsBL5A/XiEXZ7r9ywSocIFAruhZG/wXcni4qOB9Q6i2J4Dk+
        tqVHKv72LtrHE7hs8bNtJV+rQkZtxVtZLRA308PhAoGBALVEaYMRm97V+Tnsej6q
        fuT/6oKHPqZpur2rNfEKVn5Aq2kmFrvyUhvXi0IAWQ/XS3XJ7faQnprrWT6pYiSy
        2YQuaghlNG1SATVd5eUadq2pA8DuSzqWFa0Ac1IAyliBO2uLPL7LzuEKmmuQk0vI
        TU2Q8idAb77K7mvVguA3LDhN
        -----END PRIVATE KEY----- ',
        'BAOKIM_URL_SANDBOX' => 'http://kiemthu.baokim.vn',
        'BAOKIM_URL'         => 'https://www.baokim.vn',
        'BAOKIM_API_PAYMENT' => '/payment/order/version11',
    ),
    'CARDS'     => array(
        'NganLuong' => array(
            'MERCHANT_ID'         => 'merchant',
            'MERCHANT_PASSWORD'   => 'merchant',
            'EMAIL_RECEIVE_MONEY' => 'merchant@gmail.com'
        ),
        'BaoKim'    => array(
            'BAOKIM_URL'        => 'https://www.baokim.vn/the-cao/restFul/send',
            'CORE_API_HTTP_USR' => 'merchant',
            'CORE_API_HTTP_PWD' => 'merchant',
            'MERCHANT_ID'       => 'merchant',
            'API_USERNAME'      => 'merchant',
            'API_PASSWORD'      => 'merchant',
            'SECURE_CODE'       => 'merchant'
        )
    )
);



