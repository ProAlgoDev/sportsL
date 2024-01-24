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
                        <input type="text" name='selectDate' hidden/>
                    </form>
                    @if(Request::is("book_dashboard/$teamId/year"))
                    <div class="yearpicker">
                        <input  id="yearpicker"  name="selectDate" placeholder="" value="{{$selectDate}}" class="form-control  date_icon date-own" />
                    </div>
                    @endif
                    @if(Request::is("book_dashboard/$teamId/month"))
                    <div class="monthpicker">
                        <input  id="monthpicker"  name="selectDate" placeholder="" value="{{$selectDate}}" class="form-control  date_icon date-own" />
                    </div>
                    @endif
               <span class="notification">{{Request::is("book_dashboard/$teamId/all") ? '※総合計過去5年分' : '' }}</span> 
        </div>
        @if(count($book)>0)
        <div class="all_report">
                @if(Request::is("book_dashboard/$teamId/all"))
                    <div class="sum_item">
                            <div class="input"><span>総収入</span><span >{{$totalInput+$initialAmount = $initialAmount !=null ? $initialAmount:0}}円</span></div>
                            <div class="out"><span>総支出</span><span >{{$totalOutput}}円</span></div>
                            <div class="sum"><span>総合計</span><span >{{$totalInput+$totalOutput+$initialAmount}}円</span></div>
                    </div>  
                @endif
                @if(Request::is("book_dashboard/$teamId/year"))
                    <div class="sum_item">
                            <div class="input"><span>年度収入</span><span class="total_input"></span></div>
                            <div class="out"><span>年度支出</span><span class="total_output"></span></div>
                            <div class="sum"><span>年度総計</span><span class="total_sum"></span></div>
                    </div> 
                    <div class="sum_item">
                            <div class="input"><span>総収入</span><span >{{$totalInput }}円</span></div>
                            <div class="out"><span>総支出</span><span >{{$totalOutput}}円</span></div>
                            <div class="sum"><span>総合計</span><span >{{$totalInput+$totalOutput+$initialAmount}}円</span></div>
                    </div> 
                @endif
                @if(Request::is("book_dashboard/$teamId/month"))
                    <div class="sum_item">
                            <div class="input"><span>総収入</span><span class="total_input"></span></div>
                            <div class="out"><span>総支出</span><span class="total_output"></span></div>
                            <div class="sum"><span>総合計</span><span class="total_sum"></span></div>
                    </div> 
                @endif
        </div>
        @if(!Request::is("book_dashboard/$teamId/month"))
        <div class="chart_sum_title">
                {{Request::is("book_dashboard/$teamId/all") ? '年度次推移' : '' }}
                {{Request::is("book_dashboard/$teamId/year") ? '年度次推移' : '' }}
        </div>
        <div id="chart"></div>
        @endif
        <div class="item_chart_title">
                <span  class="io_title_name">項目別収入割合</span>
                <div class="content">
                        <input type="radio" id="item_input" name="item_io" checked><label for="item_input">収入</label><input type="radio" id="item_out"  name="item_io"><label for="item_out">支出</label>
                </div>
        </div>
        <div id="item_chart_in"></div>
        <div id="item_chart_out"></div>
        <div class="item_table_title">
                <span class="io_title_name">項目別収入割合</span>
        </div>
        <div class="item_table_content">
            <table>
                
            </table>
        </div>
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
    }
    var menu_back = document.getElementById('menu_background');
    document.getElementById('book_dashboard_menu_container').addEventListener('drag', function (event) {
    const deltaX = event.clientX - startX;
    if((Math.abs(deltaX)) >180){
        document.getElementById('book_dashboard_menu_container').style.transform = 'translate(-353px,0)';
    }
        menu_back.style.opacity = '0';
    setTimeout(() => {
        menu_back.style.display = 'none';
    }, .3);
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
if(initialAmount == null){
    initialAmount = 0;
}
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
// totalInput +=parseFloat(initialAmount);
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


var iTableData = @json($iTable);
var oTableData = @json($oTable);

var initialIo = $('[name = "item_io"]').attr('id');
    if(initialIo == 'item_input'){
        $('#item_chart_in').css('display', 'block');
        $('#item_chart_out').css('display', 'none');
        createTable(iTableData);

        setTimeout(() => {
        $('#item_chart_in').css('opacity', '1');
        $('#item_chart_out').css('opacity', '0');
    }, 1.5);

    }
    if(initialIo == 'item_out'){
        $('#item_chart_out').css('display', 'block');
        $('#item_chart_in').css('display', 'none');
        createTable(oTableData);

        setTimeout(() => {
        $('#item_chart_out').css('opacity', '1');
        $('#item_chart_in').css('opacity', '0');
    }, 1.5);

    }
    $('[name = "item_io"]').on('change',function(){
        if($(this).attr("id") == 'item_input'){
        $('.io_title_name').text("項目別収入割合");
        $('#item_chart_in').css('display', 'block');
        $('#item_chart_out').css('display', 'none');
        createTable(iTableData);

        setTimeout(() => {
        $('#item_chart_in').css('opacity', '1');
        $('#item_chart_out').css('opacity', '0');
    }, 1.5);
        
    }
    if($(this).attr("id") == 'item_out'){
        $('.io_title_name').text("項目別支出割合");

        $('#item_chart_out').css('display', 'block');
        $('#item_chart_in').css('display', 'none');
        createTable(oTableData);

        setTimeout(() => {
        $('#item_chart_out').css('opacity', '1');
        $('#item_chart_in').css('opacity', '0');
    }, 1.5);

    }
    });
function createTable(data){
    
var currentURL = window.location.href;
var type = currentURL.substring(currentURL.lastIndexOf('/') + 1);
var colspan = Object.keys(data).length;
var dataType ='';
if(type == 'all'){
    dataType = '年';
}else if(type == 'year'){
    dataType = '月';
}else if(type=='month'){
    dataType = '日';
}
var table = $('.item_table_content table');
let categoryList = getTableCategory(data);
var titleTr = ``;
var contentTr = ``;
var cateAmount = {};
var totalCol = ``;
Object.entries(data).map(([key,value])=>{
    cateAmount[key] = 0;
});

for (let item of categoryList){
    var td = ``;
    var rowTotal = 0;
    Object.entries(data).map(([key,value])=>{
        if(Array.isArray(value) && Object.keys(value).length == 0){
           td +=`<td>0</td>`;
        }
        else{
            if(value[item] !== undefined){
                td += `<td>${value[item]}</td>`;
                rowTotal +=parseFloat(value[item]);
                cateAmount[key] +=parseFloat(value[item]);
            }else{
                td += `<td>0</td>`;
            }
        }
    });
    td +=`<td>${rowTotal}</td>`;
    contentTr += `
    <tr>
        <td class="title item">${item}</td>
        ${td}
    </tr>`;
}
Object.entries(cateAmount).map(([key, value]) =>{
    totalCol +=`<td>${value}</td>`;
});
contentTr +=`<tr><td></td>${totalCol}<td></td></tr>`;

Object.entries(data).map(([key,value])=>{
    titleTr += `<td class='title'>${key}</td>`
})
titleTr +="<td class='row_sum'></td>";
var newTable = `
        <tr class="year_title">
            <td class="title" rowspan="2">
                支出項目
            </td>
            <td class="title title_coll" colspan=${colspan}>
                ${dataType}
            </td>
            <td class="">
            </td>
        </tr>
        <tr>${titleTr}</tr>
        ${contentTr}
       
`;
   table.html(newTable);
}


function getValuesByName(data, name) {

  for (const year in data) {
    const yearData = data[year];

    if (Array.isArray(yearData) && yearData.length === 0) {
      return 0; 
    }

    if (yearData[name] !== undefined) {
      return (yearData[name]);
    }
  }

}

function getTableCategory(data){

    category = [];
    Object.entries(data).map(([key, value])=>{
        Object.entries(value).map(([innerKey, innerValue])=>{
            if(category.indexOf(innerKey) === -1){
                category.push(innerKey);
            }
        })
    });
    return category
}


    
     $("#yearpicker").datepicker({
         format: "yyyy",
         viewMode: "years", 
         minViewMode: "years",
         autoclose:true,
         locale: 'ja'
     });
     
     $("#monthpicker").datepicker({
         format: "yyyy-mm",
         viewMode: "months", 
         minViewMode: "months",
         autoclose:true ,
         locale: 'ja'
         
     });
     $('#yearpicker').on('change',function(){
        $('[name="selectDate"]').val($(this).val());
        console.log($('[name="selectDate"]').val())
        $('#dateForm').submit();
     });
     $('#monthpicker').on('change',function(){
        $('[name="selectDate"]').val($(this).val());
        console.log($('[name="selectDate"]').val())

        $('#dateForm').submit();

     });
</script>

