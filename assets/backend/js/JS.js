// <!-- calendar -->

            $(function() {
                // Easy pie charts
                var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true // make the event "stick"
                        );
                    }
                    calendar.fullCalendar('unselect');
                },
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped
                
                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);
                    
                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    
                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                    
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                    
                },
                editable: true,
                // US Holidays
                events: 'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic'
                
                });
            });
    
            $('#external-events div.external-event').each(function() {
            
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };
                
                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);
                
                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999999999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });
                
            });

        jQuery(document).ready(function() {   
        FormValidation.init();
        });
        

            $(function() {
                $(".datepicker").datepicker();
                $(".uniform_on").uniform();
                $(".chzn-select").chosen();
                $('.textarea').wysihtml5();

                $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index+1;
                    var $percent = ($current/$total) * 100;
                    $('#rootwizard').find('.bar').css({width:$percent+'%'});
                    // If it's the last tab then hide the last button and show the finish instead
                    if($current >= $total) {
                        $('#rootwizard').find('.pager .next').hide();
                        $('#rootwizard').find('.pager .finish').show();
                        $('#rootwizard').find('.pager .finish').removeClass('disabled');
                    } else {
                        $('#rootwizard').find('.pager .next').show();
                        $('#rootwizard').find('.pager .finish').hide();
                    }
                }});
                $('#rootwizard .finish').click(function() {
                    alert('Finished!, Starting over!');
                    $('#rootwizard').find("a[href*='tab1']").trigger('click');
                });
            });
 
            $(function() {
                
            });
  
            $(function() {
                // Easy pie charts
                $('.chart').easyPieChart({animate: 1000});
            });

           
    $(document).ready(function() {
        function getDuLieuBaoCaoTongSoMatHang() {
            $.ajax('/backend/ajax/baocao-tongsomathang-ajax.php', {
                success: function (data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.quantity}</h1>`;
                    $('#baocaoSanPham_quantity').html(htmlString);
                },
                error: function () {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoSanPham_quantity').html(htmlString);
                }
            });
        }
        $('#refreshBaoCaoSanPham').click(function(event) {
            event.preventDefault();
            getDuLieuBaoCaoTongSoMatHang();
        });
        // Mới mở web
        getDuLieuBaoCaoTongSoMatHang();
        // ----------------- Tổng số khách hàng --------------------------
        function getDuLieuBaoCaoTongSoKhachHang() {
            $.ajax('/backend/ajax/baocao-tongsokhachhang-ajax.php', {
                success: function (data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.quantity}</h1>`;
                    $('#baocaoKhachHang_quantity').html(htmlString);
                },
                error: function () {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoKhachHang_quantity').html(htmlString);
                }
            });
        }
        $('#refreshBaoCaoKhachHang').click(function(event) {
            event.preventDefault();
            getDuLieuBaoCaoTongSoKhachHang();
        });
        // Mới mở web
        getDuLieuBaoCaoTongSoKhachHang();
        // ----------------- Tổng số Gops ys --------------------------
        function getDuLieuBaoCaoTongSoGopY() {
            $.ajax('/backend/ajax/baocao-tongsogopy-ajax.php', {
                success: function (data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.quantity}</h1>`;
                    $('#baocaoGopY_quantity').html(htmlString);
                },
                error: function () {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoGopY_quantity').html(htmlString);
                }
            });
        }
        $('#refreshBaoCaoGopY').click(function(event) {
            event.preventDefault();
            getDuLieuBaoCaoTongSoGopY();
        });
        // Mới mở web
        getDuLieuBaoCaoTongSoGopY();
         // ----------------- Tổng số don hang --------------------------
        function getDuLieuBaoCaoTongSoDonHang() {
            $.ajax('/backend/ajax/baocao-tongsodonhang-ajax.php', {
                success: function (data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.quantity}</h1>`;
                    $('#baocaoDonHang_quantity').html(htmlString);
                },
                error: function () {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoDonHang_quantity').html(htmlString);
                }
            });
        }
        $('#refreshBaoCaoDonHang').click(function(event) {
            event.preventDefault();
            getDuLieuBaoCaoTongSoDonHang();
        });
        // Mới mở web
        getDuLieuBaoCaoTongSoDonHang();
        

        // ------------------ Vẽ biểu đồ thống kê chu de gop y-----------------
        // Vẽ biểu đổ Thống kê Loại sản phẩm sử dụng ChartJS
        var $objChartThongKeChuDeGopY;
        var $chartOfobjChartThongKeChuDeGopY = document.getElementById("chartOfobjChartThongKeChuDeGopY").getContext(
            "2d");
        function renderChartThongKeChuDeGopY() {
            $.ajax({
                url: '/backend/ajax/baocao-thongkechudegopy-ajax.php',
                type: "GET",
                success: function (response) {
                    
                    var data = JSON.parse(response);
                    var myLabels = [];
                    var myData = [];
                    $(data).each(function () {
                        myLabels.push((this.TenChuDeGopY));
                        myData.push(this.quantity);
                    });
                    myData.push(0); // tạo dòng số liệu 0
                    if (typeof $objChartThongKeChuDeGopY !== "undefined") {
                        $objChartThongKeChuDeGopY.destroy();
                    }
                    $objChartThongKeChuDeGopY = new Chart($chartOfobjChartThongKeChuDeGopY, {
                        // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                        type: "bar",
                        data: {
                            labels: myLabels,
                            datasets: [{
                                data: myData,
                                borderColor: "#9ad0f5",
                                backgroundColor: "#9ad0f5",
                                borderWidth: 1
                            }]
                        },
                        // Cấu hình dành cho biểu đồ của ChartJS
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "Thống kê chủ đề góp ý"
                            },
                            responsive: true
                        }
                    });
                }
            });
        };
        $('#refreshThongKeChuDeGopY').click(function (event) {
            event.preventDefault();
            renderChartThongKeChuDeGopY();
        });
        renderChartThongKeChuDeGopY();
        

        // ------------------ Vẽ biểu đồ thống kê san pham-----------------
        // Vẽ biểu đổ Thống kê Loại sản phẩm sử dụng ChartJS
        var $objChartThongKeSanPham;
        var $chartOfobjChartThongKeSanPham = document.getElementById("chartOfobjChartThongKeSanPham").getContext(
            "2d");
        function renderChartThongKeSanPham() {
            $.ajax({
                url: '/backend/ajax/baocao-thongkesanpham-ajax.php',
                type: "GET",
                success: function (response) {
                    
                    var data = JSON.parse(response);
                    var myLabels = [];
                    var myData = [];
                    $(data).each(function () {
                        myLabels.push((this.TenSanPham));
                        myData.push(this.quantity);
                    });
                    myData.push(0); // tạo dòng số liệu 0
                    if (typeof $objChartThongKeSanPham !== "undefined") {
                        $objChartThongKeSanPham.destroy();
                    }
                    $objChartThongKeSanPham = new Chart($chartOfobjChartThongKeSanPham, {
                        // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                        type: "pie",
                        data: {
                            labels: myLabels,
                            datasets: [{
                                data: myData,
                                borderColor: "#9ad0f5",
                                backgroundColor: "#808000",
                                borderWidth: 1
                            }]
                        },
                        // Cấu hình dành cho biểu đồ của ChartJS
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "Thống kê sản phẩm"
                            },
                            responsive: true
                        }
                    });
                }
            });
        };
        $('#refreshThongKeSanPham').click(function (event) {
            event.preventDefault();
            renderChartThongKeSanPham();
        });
        renderChartThongKeSanPham();

        // ------------------ Vẽ biểu đồ thống kê nha san xuat-----------------
        // Vẽ biểu đổ Thống kê Loại sản phẩm sử dụng ChartJS
        var $objChartThongKeNhaSanXuat;
        var $chartOfobjChartThongKeNhaSanXuat = document.getElementById("chartOfobjChartThongKeNhaSanXuat").getContext(
            "2d");
        function renderChartThongKeNhaSanXuat() {
            $.ajax({
                url: '/backend/ajax/baocao-thongkenhasanxuat-ajax.php',
                type: "GET",
                success: function (response) {
                    
                    var data = JSON.parse(response);
                    var myLabels = [];
                    var myData = [];
                    $(data).each(function () {
                        myLabels.push((this.TenNhaSanXuat));
                        myData.push(this.quantity);
                    });
                    myData.push(0); // tạo dòng số liệu 0
                    if (typeof $objChartThongKeNhaSanXuat !== "undefined") {
                        $objChartThongKeNhaSanXuat.destroy();
                    }
                    $objChartThongKeNhaSanXuat = new Chart($chartOfobjChartThongKeNhaSanXuat, {
                        // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                        type: "doughnut",
                        data: {
                            labels: myLabels,
                            datasets: [{
                                data: myData,
                                borderColor: "#808000",
                                backgroundColor: "#9ad0f5",
                                borderWidth: 1
                            }]
                        },
                        // Cấu hình dành cho biểu đồ của ChartJS
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "Thống kê Nhà sản xuất"
                            },
                            responsive: true
                        }
                    });
                }
            });
        };
        $('#refreshThongKeNhaSanXuat').click(function (event) {
            event.preventDefault();
            renderChartThongKeNhaSanXuat();
        });
        renderChartThongKeNhaSanXuat();

        // ------------------ Vẽ biểu đồ thống kê Loại sản phẩm -----------------
        // Vẽ biểu đổ Thống kê Loại sản phẩm sử dụng ChartJS
        var $objChartThongKeLoaiSanPham;
        var $chartOfobjChartThongKeLoaiSanPham = document.getElementById("chartOfobjChartThongKeLoaiSanPham").getContext(
            "2d");
        function renderChartThongKeLoaiSanPham() {
            $.ajax({
                url: '/backend/ajax/baocao-thongkeloaisanpham-ajax.php',
                type: "GET",
                success: function (response) {
                    
                    var data = JSON.parse(response);
                    var myLabels = [];
                    var myData = [];
                    $(data).each(function () {
                        myLabels.push((this.TenLoaiSanPham));
                        myData.push(this.quantity);
                    });
                    myData.push(0); // tạo dòng số liệu 0
                    if (typeof $objChartThongKeLoaiSanPham !== "undefined") {
                        $objChartThongKeLoaiSanPham.destroy();
                    }
                    $objChartThongKeLoaiSanPham = new Chart($chartOfobjChartThongKeLoaiSanPham, {
                        // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                        type: "line",
                        data: {
                            labels: myLabels,
                            datasets: [{
                                data: myData,
                                borderColor: "#00FF00",
                                backgroundColor: "#9ad0f5",
                                borderWidth: 1
                            }]
                        },
                        // Cấu hình dành cho biểu đồ của ChartJS
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "Thống kê Loại sản phẩm"
                            },
                            responsive: true
                        }
                    });
                }
            });
        };
        $('#refreshThongKeLoaiSanPham').click(function (event) {
            event.preventDefault();
            renderChartThongKeLoaiSanPham();
        });
        renderChartThongKeLoaiSanPham();


    });

   