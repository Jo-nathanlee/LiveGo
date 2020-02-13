<table>
    <tbody>
        <tr><td colspan="9">{{ $page_name->page_name }}直播&nbsp;出貨單</td></tr>
        <tr><td colspan="9">連絡電話：{{ $phone->buyer_phone }}</td></tr>
        <tr>
            <td colspan="2">撿貨員：</td>
            <td colspan="2">出貨員：</td>
            <td colspan="5">製表時間：{{ $tabel_create_time }}</td>
        </tr>
        <tr>
            <td>FB帳號</td>
            <td colspan="7">寄送地址</td>
            <td>付款方式</td>
        </tr>
        <tr>
            <td>{{ $fb_name->fb_name }}</td>
            <td colspan="7">{{ $adderss->buyer_address }}</td>
            <td>綠界</td>
        </tr>
        <tr>
            <td colspan="3">訂單編號</td>
            <td colspan="6">訂單備註</td>
        </tr>
        <tr>
            <td colspan="3">{{ $order_id }}</td>
            <td colspan="6">{{ $note->note }}</td>
        </tr>
        <tr>
            <td colspan="2">商品名稱</td>
            <td colspan="2">規格</td>
            <td>單</td>
            <td>數</td>
            <td>小計</td>
            <td colspan="2">商品備註</td>
        </tr>
    @foreach ($streaming_order as $order)
        <tr>
           <td colspan="2">{{ $order->goods_name}}</td>
           <td colspan="2">{{ $order->category}}</td>
           <td>{{ $order->single_price}}</td>
           <td>{{ $order->order_num}}</td>
           <td>{{ (int)$order->single_price*(int)$order->order_num}}</td>
           <td colspan="2"></td>
        </tr>
    @endforeach
    @foreach ($shop_order as $order)
        <tr>
           <td colspan="2">{{ $order->goods_name}}</td>
           <td colspan="2">{{ $order->category}}</td>
           <td>{{ $order->goods_price}}</td>
           <td>{{ $order->order_num}}</td>
           <td>{{ $order->total_price}}</td>
           <td colspan="2"></td>
        </tr>
    @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>合計：</td>
            <td>{{ $total->goods_total}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>運費：</td>
            <td>{{ $freight->freight}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>總計：</td>
            <td>{{ $all_total->all_total}}</td>
        </tr>
    </tbody>
</table>
