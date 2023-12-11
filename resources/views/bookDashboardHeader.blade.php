@include('bookDashboardMenu')

<div class="book_dashboard_header">
        @include('bookDashboardLogo')
        <div class="book_header">
                <button onclick="showMenu()" id="show_menu_list"><img src='{{asset("images/avatar/$teamAvatar")}}' alt="" /></button>
                <div class="book_header_id">
                        <span class="book_header_teamName">{{$teamName}}</span>
                        <span class="book_header_teamId">#{{$teamId}}</span>
                </div>
        </div>
        <div class="book_date_switch">
                <form action="{{route('validate_book_dashboard')}}" method="POST" id='dateForm'>
                        @csrf
                        <label for="all" class="book_date_all"><input type="radio" name='date_switch' id='all' value="all" {{
                                Request::is("book_dashboard/$teamId/all") ? 'checked' : '' }} />全て</label>
                        <label for="year" class="book_date_year"><input type="radio" name='date_switch' id='year' value="year" {{
                                Request::is("book_dashboard/$teamId/year") ? 'checked' : '' }} />年次</label>
                        <label for="month" class="book_date_month"><input type="radio" name='date_switch' id='month' value="month" {{
                                Request::is("book_dashboard/$teamId/month") ? 'checked' : '' }} />月次</label>
                        
                        <input name='teamId' value="{{$teamId}}" hidden />
                </form>
               <span class="notification">{{Request::is("book_dashboard/$teamId/all") ? '※総合計過去5年分' : '' }}</span> 
        </div>
        @if(isset($book))
        <div class="all_report">
                @if(Request::is("book_dashboard/$teamId/all"))
                    <div class="sum_item">
                            <div class="input"><span>総収入</span><span class="total_input">円</span></div>
                            <div class="out"><span>総支出</span><span class="total_output">円</span></div>
                            <div class="sum"><span>総合計</span><span class="total_sum">円</span></div>
                    </div>  
                @endif
                <div class="year">
                        <div class="input"><span>年度収入</span><span>34534534円</span></div>
                        <div class="out"><span>年度支出</span><span>3453453円</span></div>
                        <div class="sum"><span>年度総計</span><span>345345円</span></div>
                </div>
                <div class="sum_item">
                        <div class="input"><span>総収入</span><span>345345345円</span></div>
                        <div class="out"><span>総支出</span><span>354345円</span></div>
                        <div class="sum"><span>総合計</span><span>345345円</span></div>
                </div>
        </div>
        <div class="chart_sum_title">
                {{Request::is("book_dashboard/$teamId/all") ? '年度次推移' : '' }}
                {{Request::is("book_dashboard/$teamId/year") ? '年度次推移' : '' }}
                {{Request::is("book_dashboard/$teamId/month") ? '月次推移' : '' }}
        </div>
        <div id="chart"></div>
        {{-- @elseif(isset($initialAmount))
        <div id="chart"></div> --}}
        <div class="item_chart_title">
                <span>項目別支出割合</span>
                <div class="content">
                        <input type="radio" id="item_input" name="item_io" checked>収入<label for="item_input"></label>  <strong>/</strong>  <input type="radio" id="item_out"  name="item_io"><label for="item_out">支出</label>  <p>の切り替え</p>
                </div>
        </div>
        <div id="item_chart_in"></div>
        <div id="item_chart_out"></div>
        <div class="item_table_title">
                <span>項目別支出割合</span>
        </div>
        <div class="item_table_content">
            <table>
                <tr class="year_title">
                    <td class="title" rowspan="2">
                        支出項目
                    </td>
                    <td class="title title_coll">
                        {{Request::is("book_dashboard/$teamId/all") ? '年' : '' }}
                        {{Request::is("book_dashboard/$teamId/year") ? '年' : '' }}
                        {{Request::is("book_dashboard/$teamId/month") ? '月' : '' }}
                    </td>
                    <td class="">
                    </td>
                </tr>
            </table>
        </div>
        <input  id="monthpicker"  name="month" placeholder="" class="form-control  date_icon date-own" />
        @else 
        @include('noBookRegister')
        @endif
</div>

<div class="menu_background" id='menu_background'></div>
<script>
       
    let startX;
    function handleDrag(event){
        startX = event.clientX;
        event.dataTransfer.setData("text/plain", startX);
        console.log(startX);
    }
    var menu_back = document.getElementById('menu_background');
    document.getElementById('book_dashboard_menu_container').addEventListener('drag', function (event) {
    const deltaX = event.clientX - startX;
    if((Math.abs(deltaX)) >270){
        menu_back.style.opacity = '0';
    setTimeout(() => {
        menu_back.style.display = 'none';
    }, .3);
                document.getElementById('book_dashboard_menu_container').style.transform = 'translate(-353px,0)';
            }
    });
    function showMenu(){
        var menu = document.getElementById('book_dashboard_menu_container');
        var menu_back = document.getElementById('menu_background');
        setTimeout(() => {
            menu_back.style.opacity = '1';
            menu_back.style.display = 'block';
        }, .3);
        menu.style.transform = 'translate(0,0)';
    }
        document.addEventListener('DOMContentLoaded', function () {
            var dateForm = document.getElementById('dateForm');
            var menu_back = document.getElementById('menu_background');
            var menu = document.getElementById('book_dashboard_menu_container');

            menu_back.addEventListener('click', function(){
                menu_back.style.opacity = '0';
            menu.style.transform = 'translate(-353px,0)';

                setTimeout(() => {
                    menu_back.style.display = 'none';
              }, .5);  
            })

                var dateSwitches = document.querySelectorAll('input[name="date_switch"]');
                dateSwitches.forEach(function (switchInput) {
                        if (switchInput.checked) {
                            var label = switchInput.parentNode;
                            label.classList.add('date_active');
                        } else {
                            var label = switchInput.parentNode;
                           if(label.classList.contains('data_active')){
                            label.classList.remove('data_active')
                           }
                        }
                });
                dateForm.addEventListener('change', function (event) {
                        if (event.target.type == 'radio') {
                                var option = event.target.value;
                                dateForm.submit();
                        }
                })
        });



//input Amount
var data = @json($inputData);
var initialAmount = @json($initialAmount);
let inputData ={};
let totalInput = 0;
let totalOut = 0;
let outData ={};
let dataSources = [];
let inputCategoryDataSources = [];
let outputCategoryDataSources = [];
let seriess = [];
let categoryInputData ={};
let categoryOuputData = {};
let categoryName = {};
let inputCategoryNameList = [];
let inputCategoryNameListTemp = [];
let outCategoryNameList = [];
let outCategoryNameListTemp = [];
Object.entries(data)
  .map(([key, value]) => {
      inputData[key] = 0;
      outData[key] = 0;
      categoryInputData = {};
      categoryInputData['date'] = key;
      categoryOuputData = {};
      categoryOuputData['date'] = key;
      Object.entries(value)
        .map(([innerKey, innerValue]) => {
          if (innerValue["ioType"] === 0) {
            categoryName = {};
            categoryName['valueField'] = innerValue["item"];
            categoryName['name'] = innerValue['item'];
            inputCategoryNameListTemp.push(categoryName);
            if(inputData[key]){
                inputData[key] += parseFloat(innerValue['amount']);
            }else{
                inputData[key] = parseFloat(innerValue['amount']);
            }

            if(categoryInputData[innerValue['item']]){
                categoryInputData[innerValue['item']] +=parseFloat(innerValue['amount']);
            }else{
                categoryInputData[innerValue['item']] = 0;
                categoryInputData[innerValue['item']] =parseFloat(innerValue['amount']);
            }

            totalInput  +=parseFloat(innerValue['amount']);
          } else if (innerValue["ioType"] === 1) {
            categoryName = {};
            categoryName['valueField'] = innerValue["item"];
            categoryName['name'] = innerValue['item'];
            outCategoryNameListTemp.push(categoryName);
            if(outData[key]){
                outData[key] += parseFloat(innerValue['amount']);
            }else{
                outData[key] = parseFloat(innerValue['amount']);
            }

            if(categoryOuputData[innerValue['item']]){
                categoryOuputData[innerValue['item']] +=parseFloat(innerValue['amount']);
            }else{
                categoryOuputData[innerValue['item']] = 0;
                categoryOuputData[innerValue['item']] =parseFloat(innerValue['amount']);
            }
            totalOut  +=parseFloat(innerValue['amount']);
          }
        });
        if(Object.keys(categoryInputData).length > 0) {
            inputCategoryDataSources.push(categoryInputData);
        }
        if(Object.keys(categoryOuputData).length > 0) {
            outputCategoryDataSources.push(categoryOuputData);
        }
  });
inputCategoryNameListTemp.forEach(item => {
    let exist = inputCategoryNameList.some(name => name.valueField === item.valueField);
    if(!exist){
        inputCategoryNameList.push(item);
    }
});
outCategoryNameListTemp.forEach(item => {
    let exist = outCategoryNameList.some(name => name.valueField === item.valueField);
    if(!exist){
        outCategoryNameList.push(item);
    }
});
let totalSum = 0;
totalInput +=parseFloat(initialAmount);
totalSum = totalInput + totalOut;
for( var index in inputData){
    let tmp = {};
    tmp['total'] = index;
    tmp['input'] = inputData[index];
    tmp['output'] = outData[index];
    dataSources.push(tmp);
}

$('.total_input').text(totalInput+"円");
$('.total_output').text(totalOut+"円");
$('.total_sum').text(totalSum+"円");

$('#chart').dxChart({
        dataSource : dataSources,
        palette: 'Harmony Lights',
        commonSeriesSettings: {
            argumentField: 'total',
            type: 'fullStackedBar',
            barPadding: .2,
        },
        series: [
            { valueField: 'input', name: '収入' },
            { valueField: 'output', name: '支出' },
            
        ],
        legend: {
            verticalAlignment: 'right',
            horizontalAlignment: 'right',
            itemTextPosition: 'right',
        },
        // title: {
        //     text: 'Energy Consumption in 2004',
        //     subtitle: {
        //         text: '(Millions of Tons, Oil Equivalent)',
        //     },
        // },
        export: {
            enabled: false,
        },
        tooltip: {
            enabled: true,
            customizeTooltip(arg) {
                return {
                    text: `${arg.percentText} - ${arg.valueText}`,
                };
            },
        },
    });


    var initialIo = $('[name = "item_io"]').attr('id');
    if(initialIo == 'item_input'){
        $('#item_chart_in').css('display', 'block');
        $('#item_chart_out').css('display', 'none');
        setTimeout(() => {
        $('#item_chart_in').css('opacity', '1');
        $('#item_chart_out').css('opacity', '0');
    }, 1.5);

    }
    if(initialIo == 'item_out'){
        $('#item_chart_out').css('display', 'block');
        $('#item_chart_in').css('display', 'none');
        setTimeout(() => {
        $('#item_chart_out').css('opacity', '1');
        $('#item_chart_in').css('opacity', '0');
    }, 1.5);

    }
    console.log($('[name = "item_io"]').attr('id'));
    $('[name = "item_io"]').on('change',function(){
        console.log($(this).attr("id"));
        if($(this).attr("id") == 'item_input'){
        $('#item_chart_in').css('display', 'block');
        $('#item_chart_out').css('display', 'none');
        setTimeout(() => {
        $('#item_chart_in').css('opacity', '1');
        $('#item_chart_out').css('opacity', '0');
    }, 1.5);
        
    }
    if($(this).attr("id") == 'item_out'){
        $('#item_chart_out').css('display', 'block');
        $('#item_chart_in').css('display', 'none');
        setTimeout(() => {
        $('#item_chart_out').css('opacity', '1');
        $('#item_chart_in').css('opacity', '0');
    }, 1.5);

    }
    });
        $('#item_chart_in').dxChart({
            dataSource : inputCategoryDataSources,
            palette: '',
            commonSeriesSettings: {
                argumentField: 'date',
                type: 'fullStackedBar',
                barPadding: 0.5,
            },
            series: inputCategoryNameList,
            legend: {
                verticalAlignment: 'right',
                horizontalAlignment: 'right',
                itemTextPosition: 'right',
            },
            
            export: {
                enabled: false,
            },
            tooltip: {
                enabled: true,
                customizeTooltip(arg) {
                    return {
                        text: `${arg.percentText} - ${arg.valueText}`,
                    };
                },
            },
        });


        $('#item_chart_out').dxChart({
            dataSource : outputCategoryDataSources,
            palette: '',
            commonSeriesSettings: {
                argumentField: 'date',
                type: 'fullStackedBar',
                barPadding: 0.5,
            },
            series: outCategoryNameList,
            legend: {
                verticalAlignment: 'right',
                horizontalAlignment: 'right',
                itemTextPosition: 'right',
            },
            
            export: {
                enabled: false,
            },
            tooltip: {
                enabled: true,
                customizeTooltip(arg) {
                    return {
                        text: `${arg.percentText} - ${arg.valueText}`,
                    };
                },
            },
        });


console.log(inputCategoryDataSources);

    $('.title_coll').attr('rowspan',Object.keys(data).length);
    var tBody = $('.item_table_content table tbody');
    var tr = $('<tr><td></td>')
    console.log($('.item_table_content table tbody'))
     $("#yearpicker").datepicker({
         format: "yyyy",
         viewMode: "years", 
         minViewMode: "years",
         autoclose:true //to close picker once year is selected
     });
     
     $("#monthpicker").datepicker({
         format: "yyyy-mm",
         viewMode: "months", 
         minViewMode: "months",
         autoclose:true //to close picker once year is selected
     });
</script>

