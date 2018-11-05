<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- icon -->
    <link rel="Shortcut Icon" type="image/x-icon" href="img/livego.png" />
    <title>Live GO</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <!--導覽列-->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <!--標題列-->
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
    <!--通知列-->
    <link rel="stylesheet" href="{{ asset('css/LiveGO.css') }}">
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
    <!-- iconfont CSS -->
    <link rel="stylesheet" href="{{ asset('css/icofont.css') }}">
    <link href="{{ asset('css/alertify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>
    <!-- alterfy  -->
    <script src="{{ asset('js/alertify.js') }}"></script>
</head>


<body id="gray_bg">
    <div class="row">
        <div class="container">
        <div class="col-md-4 offset-md-4 text-center offset-sm-4 col-sm-4" id="log_in">
            <div class="login">
                <img src="img/livego.png" />
                <H4 class="text-dark">來福狗</H4>
                <small class="d-block text-dark mb-3">直播電商智慧小幫手</small>

                <button onclick="window.location.href='/login/facebook'" class="btn btn-lg btn-primary btn-block mt-4 mb-4" type="submit">Login</button>
                <!-- <div class="col-md-8 col-offset-2">
                     <a class="btn btn-primary mb-3" href="/login/facebook">
                        Login
                    </a>
                   
                </div> -->

                <small id="Privacy" >* By logging in, you agree to our Terms of Use  & updates and acknowledge that you read our <a href="#"> Privacy Policy </a>.</small>
            </div>
        </div>
        </div>
    </div>
    <div id="Terms_content" class="d-none" style="font-family:Microsoft JhengHei;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">服務條款</h4>
                <P>1. 引言</P>
                <P>1.1 歡迎使用Live GO平台 (下稱「本網站」)。使用本網站前請詳細閱讀以下服務條款，以瞭解您對於Live GO的法律權利與義務。我們提供的服務（下稱「本服務」）包括 (a) 本網站及 (b) 透過本網站或其相關服務所提供的所有資訊、連結網頁、功能、資料、文字、影像、相片、圖形、音樂、聲音、影片、訊息、標籤、內容、程式設計、軟體、應用程式服務
                    (包括但不限於任何行動應用服務) (下稱「內容」)。本服務的任何新增或增強功能亦應受本服務條款的約束。這些服務條款規範您對於我們Live GO所提供之服務的使用行為。</P>
                <P>1.2 在成為本網站的使用者之前，您必須閱讀並接受本服務條款所包含、及連結至本服務條款之所有條款，且您必須同意隱私權政策（連結至本服務條款）中有關於處理您的個人資料之規定。</P>
                <P>1.3 Live GO保留隨時因應法規要求或符合誠信原則而變更、修改、暫停或中止本網站或服務一部或全部的權利。Live GO可能會以試用版發行某些服務或其功能，這些服務或功能可能無法正確運作或如同最終發行版本般運作。Live
                    GO亦可因應法規要求或符合誠信原則而對某些功能設定限制，或限制您存取部分或全部本網站或服務之權限。
                </P>
                <P>1.4 Live GO保留拒絕提供您存取本網站或服務之權限或允許您因任何原因開設帳戶之權利。</P>
                <P>如您使用Live GO服務，表示您不可撤回地接受與同意本協議之條款，包括本協議提及/或本協議超連結所提供的額外條款及政策。 如果您不同意這些條款，請勿使用我們的服務或存取本網站。如果您未滿 18 歲或根據您所屬國家適用之法律規定得同意本協議之法定年齡（下稱「法定年齡」），您必須取得父母或法定監護人的許可，且該父母或法定監護人必須同意本協議的條款。如果您不確定是否已達到法定年齡，或不瞭解本條款所述內容，您應先尋求父母或法定監護人的協助及同意。
                </P>
                <P>2. 隱私權</P>
                <P>2.1 Live GO非常重視您的隱私權。為更有效地保護您的權利，我們特別在 LiveGO.com 隱私權政策中詳細說明我們的隱私權作法。請審閱該隱私權政策，以瞭解Live GO如何收集並使用有關您的帳戶及/或您使用服務的資訊（下稱「使用者資訊」）。如您使用本服務或在本網站提供資訊，即表示您：
                    (a) 同意讓Live GO根據隱私權政策所述方式收集、使用、揭露及/或處理您的內容、個人資料及使用者資訊； (c) 未經Live GO事前書面同意，您不得直接或間接向第三人揭露您的使用者資訊或允許任何第三人接觸或使用您的使用者資訊。
                    2.2 使用本服務而持有其他使用者個人資料之使用者（下稱「接受方」）同意將(i)遵守所有與該個人資料相關之個人資料保護法規；(ii) 允許被接受方收集個人資料之使用者（下稱「揭露方」）得自接受方之資料庫移除他/她的資料；以及(iii)
                    允許揭露方檢視其被收集方收集之資料為何。在上述(ii)及(iii)之情形，遵守或依適用法規辦理。
                </P>
                <P>
                    3. 使用條款
                </P>
                <P>
                    3.1 本網站和服務的使用授權在終止前皆有效。如發生本服務條款所載之終止事由或是您未遵循本服務條款之任何條款或條件的情況時，此授權將會終止。在這些情況下，Live GO可另行通知您逕行終止授權。
                </P>
                <P>
                    3.2 您同意不會： (a) 上傳、張貼、傳送或以任何其他形式提供任何違法、傷害、威脅、侮辱、騷擾、危言聳聽、令人痛苦、扭曲、誹謗、粗俗、淫穢、詆毀、侵犯他人隱私、憎恨、種族歧視或在道德上或其他方面令人反感的內容； (b) 違反任何法律（包括但不限於進出口限制相關法規）、第三方權利或我們的「禁止和限制商品政策」；
                    (c) 以任何方式使用本服務傷害未成年人； (d) 使用本服務冒充任何人或實體，或虛報您與任何人或實體的關係； (e) 偽造標題或操弄識別方式，以混淆透過本服務傳送之任何內容的來源； (f) 從本網站上移除任何所有權標示；
                    (g) 在未經Live GO明確許可的情況下，致使、准許或授權修改、創作衍生著作或翻譯本服務； (h) 為任何第三方之利益或非本條款授予許可的任何方式使用本服務； (i) 將本服務使用於詐欺用途； (j)
                    操控任何商品價格或干擾其他使用者的刊登行為； (k) 採取任何會破壞反饋或排名系統的行動； (l) 試圖解碼、反向工程、拆解或駭入本服務 (或其任何部分)，或試圖破解Live GO針對本服務及/或Live
                    GO所傳輸、處理或儲存之資料所採取的任何加密技術或安全措施； (m) 採集或收集有關其他帳戶所有人的任何資訊，包括但不限於任何個人資料或資訊； (p) 上傳、以電子郵件寄送、張貼、傳送或以其他形式提供任何未經請求或未經授權的廣告、促銷資料、垃圾郵件、廣告信件、連鎖信、金字塔騙局或其他任何未經授權形式的推銷內容；
                    (q) 上傳、以電子郵件寄送、張貼、傳送或以其他形式提供任何含有意圖直接或間接干擾、操縱、中斷、破壞或限制任何電腦軟體、硬體、資料或通訊設備功能或完整性之電腦病毒、蠕蟲、木馬或任何其他電腦代碼、常式、檔案或程式的資料；
                    (r) 破壞正常的對話流程、造成螢幕快速捲動致使本服務其他使用者無法打字，或對其他使用者參加即時交流的能力造成負面影響； (s) 干擾、操縱或破壞本服務或與本服務連線之伺服器或網路或任何其他使用者對本服務之使用或享受，或不遵守本網站連線網路之任何規定、程序、政策或規範；
                    (t) 採取或參與任何可能直接或間接造成本服務或與本服務連線之伺服器或網路損害、癱瘓、負載過重或效能降低的行動或行為； (u) 使用本服務以蓄意或非蓄意地違反任何適用的當地、州、國家或國際法律、規定、守則、指令、準則、政策或規範，包括但不限於任何與反洗錢或反恐怖主義相關的法律和規定
                    (無論是否具有法律效力)； (v) 以違反或規避由美國財政部外國資產管制辦公室、聯合國安全理事會、歐盟或其財政機關所主管或執行之處罰或禁運的方式使用本服務； (w) 使用本服務侵犯他人隱私、跟蹤或以其他方式騷擾他人；
                    (x) 侵犯Live GO的權利，包括智慧財產權和相關仿冒行為； (y) 以前述禁止之行為和活動使用本服務以收集或儲存其他使用者之個人資料；及/或 (z) 刊登侵犯第三方著作權、商標或其他智慧財產權的項目，或以侵害他人智慧財產權的方式來使用本服務。
                </P>
                <P>
                    3.3 瞭解所有內容，無論其為公開張貼或私下傳送，均為該內容提供者之責任。亦即，您應對您透過本網站上傳、張貼、以電子郵件寄送、傳送或以其他方式提供之所有內容(包括但不限於內容之任何錯誤或遺漏)負完全責任，而非Live GO。您瞭解使用本網站時，您可能會接觸到具攻擊性、不雅或令人不悅之內容。
                </P>
                <P>
                    3.4 您理解Live GO和其受託人有權 (但無義務)因應法規要求或符合誠信原則預先篩選、拒絕、刪除、移除或移動任何透過本網站提供的內容（包括但不限於您透過本網站所提供之內容或資訊），例如Live GO和其受託人有權移除任何 (i) 違反本服務條款的內容；(ii)
                    遭其他使用者投訴的內容；(iii) 我們收到其侵害智慧財產權之通知或其他要求移除的法律指示之內容；或 (iv) 會造成他人反感的內容。此外，我們亦可能為了保護本服務或我們的使用者，或為了實行本條款與條件之規定，而封鎖進出本服務的通訊傳遞
                    (包括但不限於狀態更新、貼文、訊息及/或聊天室)。您同意您了解且已評估使用任何內容的所有相關風險，包括但不限於對於這類內容之正確性、完整度或實用性的倚賴。
                </P>
                <P>
                    3.5 您承認、允許並同意，若依法律要求，或根據法院命令或對Live GO有管轄權之任何政府或監督主管機關之處分，或基於善意及誠信原則認有合理之必要性時，Live GO得存取、保存及揭露您的帳戶資訊和內容，以：(a) 遵守法律程序；(b) 執行本服務條款；(c)
                    回應任何侵害第三方權利的內容之申訴；(d) 回應您的客戶服務請求；或者 (e) 保護Live GO、其使用者及公眾的權利、財產或人身安全。
                </P>
                <P>
                    4. 違反我們的服務條款
                </P>
                <P>
                    4.1 違反此政策可能導致一系列處分動作，包括但不限於下列任何或全部項目： - 刪除刊登商品 - 限制帳戶權限 - 中止帳戶及隨後終止 - 刑事訴訟 - 民事求償，包括但不限於請求損害賠償及/或聲請保全處分
                </P>
                <P>
                    4.2 如果您發現本網站的任何使用者違反本服務條款，請聯絡LiveGO客服。
                </P>
                <P>
                    5. 購買與付款
                </P>
                <P>
                    5.1 Live GO或其合作之金流服務商在其運營的國家支援一種或多種下列付款方式： (i) 信用卡 信用卡付款是透過第三方支付管道處理款項，而這些支付管道所接受的信用卡類型會因您所在的管轄地不同而有差異。 (ii) 貨到付款（COD） Live
                    GO或其合作之金流服務商在其選定的國家提供COD服務，買方得於收到購買的商品時直接給付現金給運送人。 (iii) 銀行轉帳 買方可透過自動提款機或網路銀行轉帳 (下稱「銀行轉帳」) 將款項匯入我方指定的Live
                    GO履約保證帳戶 (如第 11 條所定義)。買方必須透過Live GO或其合作之金流服務商應用程式中的「上傳收據」功能，向Live GO或其合作之金流服務商提供轉帳單據或付款交易參考，以供查驗。如果Live
                    GO或其合作之金流服務商未在三天內收到付款確認，將會取消買方訂單。
                </P>
                <P>
                    5.2 買方只能在付款前變更付款方式。
                </P>
                <P>
                    5.3 買方支付完成前，應依Live GO提供的再確認機制確認支付指示是否正確。因不可歸責於消費者的事由而發生支付錯誤時，Live GO或其合作之金流服務商將協助消費者更正並提供其他必要之協助。因可歸責於Live GO或其合作之金流服務商的事由而發生支付錯誤時，Live
                    GO或其合作之金流服務商將於知悉時立即更正，並同時以電子郵件、簡訊或App推播等方式通知消費者。因可歸責於消費者的事由而發生支付錯誤時，例如輸入錯誤之金額或輸入錯誤之收款方，經消費者通知後，Live GO或其合作之金流服務商將立即協助處理。我們有權查核買方是否具備使用特定付款方式之充分授權，並可在授權獲得確認之前暫停交易，或在未能獲得確認的情況下取消相關交易。買方完成每筆款項支付後，Live
                    GO將以電子郵件、簡訊或App推播等方式通知買方支付明細，並於買方的蝦皮錢包即時顯示支付明細供買家查詢。
                </P>
                <P>
                    5.4 目前Live GO或其合作之金流服務商僅透過銀行轉帳方式支付給使用者的款項，故使用者應提供其銀行帳戶資料給Live GO以取得商品銷售金額或退款。
                </P>
            </div>
        </div>
    </div>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="{{ asset('js/Live_go.js') }}"></script>

</body>

</html>
