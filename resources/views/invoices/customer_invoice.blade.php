
<div style="margin-left:auto;margin-right:auto;">
    <style media="all">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700');
        *{
            margin: 0;
            padding: 0;
            line-height: 1.5;
            font-family: 'Open Sans', sans-serif;
            color: #333542;
        }
        div{
            font-size: 1rem;
        }
        .gry-color *,
        .gry-color{
            color:#878f9c;
        }
        table{
            width: 100%;
        }
        table th{
            font-weight: normal;
        }
        table.padding th{
            padding: .5rem .7rem;
        }
        table.padding td{
            padding: .7rem;
        }
        table.sm-padding td{
            padding: .2rem .7rem;
        }
        .border-bottom td,
        .border-bottom th{
            border-bottom:1px solid #eceff4;
        }
        .text-left{
            text-align:left;
        }
        .text-right{
            text-align:right;
        }
        .small{
            font-size: .85rem;
        }
        .strong{
            font-weight: bold;
        }
    </style>

    @php
        $generalsetting = \App\GeneralSetting::first();
    $invoicesetting = \App\Invoice::first();
    @endphp

    <div style="background: #eceff4;padding: 1.5rem;">
        <table>
            <tr>
                <td>

                        @if($generalsetting->logo != null)
                            <img loading="lazy"  src="{{ public_path($generalsetting->logo) }}" height="60" style="display:inline-block;">
                        @else
                            <img loading="lazy"  src="{{ asset('frontend/images/logo/logo.png') }}" height="60" style="display:inline-block;">
                        @endif
                </td>


            </tr>
            <tr>
                <td style="font-size: 2rem;" class="strong">
                    INVOICE
                </td>
                <td style="font-size: 1.5rem;" class="strong text-right">فاتورة</td>
            </tr>
            <tr>
                <td style="font-size: 12px">Food & Fine Pastries Manufacturing Co. (Sunbulah)</td>
                <td class="text-right">(شركة صناعات الأغذية والعجائن الفاخرة (السنبلة</td>
            </tr>
            <tr>
                <td style="font-size: 12px">Saudi Closed joint Stock Co.</td>
                <td class="text-right">شركة مساهمة سعودية مغلقة</td>
            </tr>

        </table>
        <table>
            @if (Auth::user()->user_type == 'seller')
                <tr>
                    <td style="font-size: 1.2rem;" class="strong">{{ Auth::user()->shop->name }}</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ Auth::user()->shop->address }}</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td class="gry-color small">Email: {{ Auth::user()->email }}</td>
                    <td class="text-right small"><span class="gry-color small">Order ID:</span> <span class="strong">{{ $order->code }}</span></td>
                </tr>
                <tr>
                    <td class="gry-color small">Phone: {{ Auth::user()->phone }}</td>
                    <td class="text-right small"><span class="gry-color small">Order Date:</span> <span class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
                </tr>
            @else
{{--                <tr>--}}
{{--                    <td style="font-size: 1rem;" class="strong">{{ $invoicesetting->name_english }}</td>--}}
{{--                    <td class="text-right"style="font-size: 1.2rem;" > {{$invoicesetting->name_arabic}}</td>--}}
{{--                </tr>--}}
                <tr>
                    <td class="gry-color small">{{ $generalsetting->address }}</td>
                    <td class="text-right gry-color small">المركز الرئيسي: ص.ب. 8960 – جدة 21492 – المملكة العربية السعودية</td>
                </tr>
                <tr>
                    <span>
                    <td class="gry-color small">Email: {{ $generalsetting->email }}</td>
                    <td class="text-right gry-color small"><span>{{ $generalsetting->email }}</span>: البريد الالكتروني</td>
                </tr>
                <tr>
                    <td class="gry-color small">Phone: {{ $generalsetting->phone }}</td>
                    <td class="text-right gry-color small">تليفون: 8393-614-12-966</td>
                </tr>
            <tr>
                <td class="small"><span class="gry-color small">Invoice ID:</span> <span class="strong">{{ $order->code }}</span></td>
                <td class="text-right small gry-color">{{ $order->code }} : رقم الفاتورة</td>
            </tr>
            <tr>
                <td class=" small"><span class="gry-color small">Order Date:</span> <span class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
                <td class="small gry-color text-right">{{ date('d-m-Y', $order->date) }} : تاريخ أمر الشراء</td>
            </tr>
                <tr>
                    <td class="gry-color small">VAT No: {{ $invoicesetting->vat_no }}</td>
                    <td class="gry-color small text-right">{{ $invoicesetting->vat_no }} : ضريبة القيمة المضافة لا
                    </td>
                </tr>
                <tr>
                    <td class="gry-color small">Paid capital: 100 million</td>
                    <td class="gry-color small text-right">رأس المال المدفوع: 100 مليون</td>
                </tr>
            @endif
        </table>

    </div>

    <div style="border-bottom:1px solid #eceff4;margin: 0 1.5rem;"></div>

    <div style="padding: 1.5rem;">
        <table>
            @php
                $shipping_address = json_decode($order->shipping_address);
            @endphp
            <tr><td class="strong small gry-color">Bill to:</td></tr>
            <tr><td class="strong">{{ $shipping_address->name }}</td></tr>
            <tr><td class="gry-color small">{{ $shipping_address->address }}, {{ $shipping_address->city }}, {{ $shipping_address->country }}</td></tr>
            <tr><td class="gry-color small">Email: {{ $shipping_address->email }}</td></tr>
            <tr><td class="gry-color small">Phone: {{ $shipping_address->phone }}</td></tr>
        </table>
    </div>

    <div style="padding: 1.5rem;">
        <table class="padding text-left small border-bottom">
            <thead>
            <tr class="gry-color" style="background: #eceff4;">
                <th width="35%">Product Name <br> اسم المنتج</th>
                <th width="10%">Qty <br>الكمیة</th>
                <th width="15%">Unit Price <br>سعر الوحده</th>
                <th width="10%">VAT 5% <br>ضریبة</th>
                <th width="15%" class="text-right">Total+VAT(5%) <br>مجموع</th>
            </tr>
            </thead>
            <tbody class="strong">
            @foreach ($order->orderDetails as $key => $orderDetail)
                @if ($orderDetail->product)
                    <tr class="">
                        <td>{{ $orderDetail->product->name }} ({{ $orderDetail->variation }})</td>
                        <td class="gry-color">{{ $orderDetail->quantity }}</td>
                        <td class="gry-color">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
                        <td class="gry-color">{{ single_price($orderDetail->tax/$orderDetail->quantity) }}</td>
                        <td class="text-right">{{ single_price($orderDetail->price+$orderDetail->tax) }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="padding:0 1.5rem;">
        <table style="width: 40%;margin-left:auto;" class="text-right sm-padding small strong">
            <tbody>
            <tr>
                <th class="gry-color text-left">Sub Total / المجموع الفرعي</th>
                <td>{{ single_price($order->orderDetails->sum('price')) }}</td>
            </tr>
            <tr class="border-bottom">
                <th class="gry-color text-left">VAT (5%) / ضریبة</th>
                <td>{{ single_price(json_decode($order->shipping_address)->vat) }}</td>
            </tr>
            <tr>
                <th class="gry-color text-left">Shipping Cost / تكلفة الشحن</th>
                <td>{{ single_price(json_decode($order->shipping_address)->shipping_cost) }}</td>
            </tr>
            <tr>
                <th class="gry-color text-left">Shipping VAT / ({{json_decode($order->shipping_address)->shipping_charge_vat_percentage}}%) ضريبة القيمة المضافة للشحن</th>
                <td>{{ single_price(json_decode($order->shipping_address)->shipping_charge_vat) }}</td>
            </tr>
            <tr>
                <th class="text-left strong">Grand Total / الإجمالي المبلغ</th>
                <td>{{ single_price($order->grand_total) }}</td>
            </tr>
            </tbody>
        </table>
    </div>

<br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div style="padding: 1.5rem;">
        <table class="padding text-left small border-bottom">
            <thead>
            <tr class="gry-color" style="background: #eceff4;">
                <th width="35%">Terms and Conditions</th>
                <th width="15%">الشروط والأحكام</th>

            </tr>
            </thead>
            <tbody class="strong">

                    <tr class="">

                        <td class="gry-color"> We will exert our best endeavors to deliver the Products mentioned in this invoice within 5 working days and in case of any delay we will inform you.</td>
                        <td class="gry-color text-right">	سنقوم ببذل قصارى جهدنا من أجل توصيل المنتجات المبينة في الفاتورة خلال 5 أيام عمل وفي حالة عدم قدرتنا على التوصيل لأي سبب خلال هذه المدة سنقوم بإبلاغ المشتري بذلك.</td>

                    </tr>
                    <tr class="">

                        <td class="gry-color ">Customer shall inspect the Products upon delivery and inform the seller with shortage and/or defects in the Products immediately, failure to do so, seller shall not be liable and receiving the Products shall be deemed as the customer acceptance of Products. </td>
                        <td class="gry-color text-right">يجب علي العميل فحص المنتجات عند استلامها وإبلاغ البائع بأي نقص أو عيوب في المنتجات فوراً، وفي حال عدم التزام العميل بالفحص عند الاستلام فلا يتحمل البائع أية مسئولية ويعتبر استلام المنتجات بمثابة إقرار اً من العميل بقبول المنتجات</td>

                    </tr>
                    <tr class="">

                        <td class="gry-color">The customer shall follow the storage instructions of the goods and shall be fully liable for the goods and the damages that occur as a result of the breach of the storing instructions from the time the customer receives the goods.</td>
                        <td class="gry-color">يجب على العميل باتباع إرشادات التخزين الخاصة بالمنتجات، ويتحمل العميل المسئولية الكاملة عن المنتجات والأضرار التي تحدث نتيجة الاخلال بإرشادات التخزين وذلك من وقت استلامك لها</td>

                    </tr>
                    <tr class="">

                        <td class="gry-color">In the event of any manufacturing defect in the goods, the customer must immediately cease dealing on such goods and notify seller to start recovering them.</td>
                        <td class="gry-color">في حالة ظهور أي عيب تصنيعي في البضائع، يلتزم العميل بوقف التعامل الفوري على هذه البضائع وإخطار البائع للعمل على ارتجاعها</td>

                    </tr>
                    <tr class="">

                        <td class="gry-color">Without prejudice to No. (4), the customer is not entitled to recover or return any products delivered except after seller’s approval to such recovery and after seller inspects the goods subject of recovery and identifying the reason for same. seller may reject or approve such recovery as per the norms in the Kingdom of Saudi Arabia.</td>
                        <td class="gry-color">مع عدم الاخلال بالبند (4) لا يحق للعميل استرجاع أو إعادة أية منتجات تم تسليمها إلا بعد موافقة البائع على هذا الاسترجاع وبعد ان يقوم البائع بفحص البضائع المرغوب في استرجاعها ومعرفة السبب وراء ذلك، ويحق للبائع قبول أو رفض هذا الاسترجاع حسب المتعارف عليه بأنظمة المملكة العربية السعودية</td>

                    </tr>

            </tbody>
        </table>
    </div>

</div>
