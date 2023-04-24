
$('#submit').on('click', function() {
    $itemCode = $('#item_code').val();
    $itemQuantity = $('#qty').val();
    $date = getFormattedDateTime().unFoDate;
    if($itemCode === '' || $itemQuantity === ''){
      $('#err1').text('Please fill both fields');
    }else{
      reduceInventory($itemCode, $itemQuantity, $date);
      retrieveTransactions();
    }
    $('#item_code').val('');
    $('#qty').val('');
  });

$('#goToInventory').on('click', function() {
  window.location.href = 'inventory.php';
 });

const myButton = $('#printTrans');
myButton.text('Loading ...');
myButton.prop('disabled', true);

retrieveList();
$('#createItem').on('click', () => {
  $name = $('#item-name').val();
  $variety = $('#item-variety').val();
  $brand = $('#item-brand').val();
  $price = $('#item-price').val();
  $qty = $('#item-qty').val();
  $code = $('#item-code').val();
  if($name === '' || $variety === '' || $brand === '' || $price === '' || $qty === '' || $code === '' ){
    $('#err2').text('Please fill out all fields');
  }else{
    addToDB($name, $variety, $brand, $price, $qty, $code);
    retrieveList();
  }
  $('#item-name').val('');
  $('#item-variety').val('');
  $('#item-brand').val('');
  $('#item-price').val('');
  $('#item-qty').val('');
  $('#item-code').val('');
});   

function addToDB(name, variety, brand, price, qty, code) {
  fetch('server.php', {
      method: 'POST',
      body: new URLSearchParams({
          name: name,
          variety: variety,
          brand: brand,
          price: price,
          qty: qty,
          code: code,
          loc: 'addToDb'
      }),
  })
  .then(response => {
      if (response.ok) {
        $('#item-name').val('');
        $('#item-variety').val('');
        $('#item-brand').val('');
        $('#item-price').val('');
        $('#item-qty').val('');
        $('#item-code').val('');
      } else {
          console.log("Fetch unsuccessful");
      }
  })
  .catch(error => console.error(error));		
}

function retrieveList(){
  $('#inventory-table').empty();
  fetch('server.php', {
      method: 'POST',
      body: new URLSearchParams({
          loc: 'retrieveList'
      }),
  })
  .then(response => response.json())
  .then(itemsResult => {
    console.log(itemsResult);
    var $newElement = $('<tbody></tbody>');
    itemsResult.forEach(function(item) {
        var $listDisplay = '<tr id="'+item.id+'"><td>'+item.name+'</td><td>'+item.variety+'</td><td>'+item.brand+'</td><td>'+item.quantity+'</td><td><a href="#">Edit</a></td></tr>';
        $newElement.append($listDisplay);          
    });  
    $('#inventory-table').append('<thead> <tr> <th colspan="4">Inventory</th> </tr><tr> <th>Name</th> <th>Variety</th> <th>Brand</th> <th>Quantity</th> <th></th></tr></thead>');
    $('#inventory-table').append($newElement);
    
  })
  .catch(error => console.error(error));	
}

retrieveTransactions();
function retrieveTransactions() {
  $('#result').empty();
  $('#resultsTable').empty();
  fetch('server.php', {
      method: 'POST',
      body: new URLSearchParams({
          loc: 'retrieveTransactions'
      }),
  })
  .then(response => response.json())
  .then(transactionsResult => {
    console.log(transactionsResult);
    $newElement = $('<div class="row form-group header"></div>');
    $newElement2 = $('<tbody></tbody>');
    let total = 0;
    transactionsResult.forEach(function(transaction) {
      const subAmount = transaction.price * transaction.quantity_reduced;
      var $listDisplay = `<div style="text-align: right;" class="col-sm-3"><label class="label-control">`+transaction.name+`</div>
                          <div style="text-align: right;" class="col-sm-3"><label class="label-control">`+transaction.price+`</div>
                          <div style="text-align: right;" class="col-sm-3"><label class="label-control">`+transaction.quantity_reduced+`</div>
                          <div style="text-align: right;" class="col-sm-3"><label class="label-control">`+subAmount+`</div>`;

      var $listDisplay2 = `<tr><td style="border-right: 1px solid #4CAF50; padding-left:10px;">`+transaction.name+`</td>
                            <td style="border-right: 1px solid #4CAF50; padding-left:10px;">`+transaction.price+`</td>
                            <td style="border-right: 1px solid #4CAF50; padding-left:10px;">`+transaction.quantity_reduced+`</td>
                            <td style="border-right: 1px solid #4CAF50; padding-left:10px;">`+subAmount+`</td></tr>`;
      $newElement.append($listDisplay);  
      $newElement2.append($listDisplay2); 
      total += subAmount;        
    });  
    $('#result').append(`<div class="row form-group header">
                            <div style="text-align: right; color: #4CAF50; font-size: 25px;" class="col-sm-3"><label class="label-control">Name</div>
                            <div style="text-align: right; color: #4CAF50; font-size: 25px;" class="col-sm-3"><label class="label-control">Price</div>
                            <div style="text-align: right; color: #4CAF50; font-size: 25px;" class="col-sm-3"><label class="label-control">Quantity</div>
                            <div style="text-align: right; color: #4CAF50; font-size: 25px;" class="col-sm-3"><label class="label-control">Subamount</div>
                        </div>`);
    $('#result').append($newElement);
    $('#result').append(`<div class="row form-group header">
    <div style="text-align: right;" class="col-sm-12"><label class="label-control">Total: ₱${total}</div>
    </div>`);
  
    $('#resultsTable').append(`<thead>
                            <tr><td colspan="4"><h4 style="padding: 10px; margin-bottom: 0; border-bottom: 1px solid #4CAF50;">Transactions (Table)</h4></td></tr>
                            <tr>
                              <th colspan="1" style="border-bottom: 1px solid #4CAF50; border-right: 1px solid #4CAF50; text-align: center;">Name</th>
                              <th colspan="1" style="border-bottom: 1px solid #4CAF50; border-right: 1px solid #4CAF50; text-align: center;">Price</th>
                              <th colspan="1" style="border-bottom: 1px solid #4CAF50; border-right: 1px solid #4CAF50; text-align: center;">Quantity</th>
                              <th colspan="1" style="border-bottom: 1px solid #4CAF50; text-align: center;">Subamount</th>
                            </tr>
                        </thead>`);
    $('#resultsTable').append($newElement2);
    $('#resultsTable').append(`<tfoot><tr><td colspan="4" style="text-align: right; font-weight: bold; border-top: 1px solid #4CAF50"> Total: ₱${total}</td></tr></tfoot>`);
    
  })
  .catch(error => console.error(error));	
}

function reduceInventory(itemCode, itemQuantity, date) {
  fetch('server.php', {
      method: 'POST',
      body: new URLSearchParams({
          itemCode: itemCode,
          itemQuantity: itemQuantity,
          date: date,
          loc: 'reduceInventory'
      }),
  })
  .then(response => {
    if (response.ok) {
      location.reload();
    } else {
        console.log("Fetch unsuccessful");
    }
  })
  .catch(error => console.error(error));	
}

function getFormattedDateTime() {
  const date = new Date();

  const dateOptions = { month: 'long', day: 'numeric', year: 'numeric' };
  const formattedDate = date.toLocaleDateString('en-US', dateOptions);

  const timeOptions = { hour: 'numeric', minute: 'numeric', second: 'numeric' };
  const formattedTime = date.toLocaleTimeString('en-US', timeOptions);

  const unFormattedDate = date.toISOString().slice(0, 10);

  return { date: formattedDate, time: formattedTime, unFoDate: unFormattedDate};
}

$('#inventory-table').on('click', 'tr:not(:eq(0), :eq(1))', function() {
  $ID = $(this).attr('id');
  $('#editForm').show();
  retrieveItem($ID);
});

$('#cancelItem').on('click', () => {
  $('#editForm').hide();
});

$('#updateItem').on('click', () => {
  $name = $('#update-name').val();
  $brand = $('#update-brand').val();
  $quantity = $('#update-quantity').val();
  $id = $('#update-id').val();
  updateItem($id, $name, $brand, $quantity);
  $('#editForm').hide();
  location.reload();
});

function retrieveItem(id){
  fetch('server.php', {
      method: 'POST',
      body: new URLSearchParams({
          id: id,
          loc: 'retrieveItem'
      }),
  })
  .then(response => response.json())
  .then(itemsResult => {
    console.log(itemsResult[0].name);
    $('#update-name').val(itemsResult[0].name);
    $('#update-brand').val(itemsResult[0].brand);
    $('#update-quantity').val(itemsResult[0].quantity);
    $('#update-id').val(itemsResult[0].id);
  })
  .catch(error => console.error(error));	
}

function updateItem(id, name, brand, quantity){
  fetch('server.php', {
    method: 'POST',
    body: new URLSearchParams({
        id: id,
        name: name,
        brand: brand,
        quantity: quantity,
        loc: 'updateItem'
    }),
  })
  .then(response => {
    if (response.ok) {

    } else {
        console.log("Fetch unsuccessful");
    }
  })
  .catch(error => console.error(error));		
}

$('#printTrans').on('click', () => {
  window.print();
});



function createGraph(){
  const salesTable = document.getElementById('resultsTable');
  const brandAmounts = {};
  for (let i = 2; i < salesTable.rows.length-1; i++) {
    const brand = salesTable.rows[i].cells[0].innerText;
    const amount = Number(salesTable.rows[i].cells[2].innerText);
    if (brand in brandAmounts) {
      brandAmounts[brand] += amount;
    } else {
      brandAmounts[brand] = amount;
    }
  }

  // Convert the brand amounts object to arrays for Chart.js
  const brands = Object.keys(brandAmounts);
  const amounts = Object.values(brandAmounts);
// Destroy the existing Chart object
const existingChart = Chart.getChart('sales-chart');
if (existingChart) {
  existingChart.destroy();
}
  // Create a line graph using Chart.js
  const ctx = document.getElementById('sales-chart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: brands,
      datasets: [{
        label: 'Amount Sold',
        data: amounts,
        borderColor: '#4CAF50',
        fill: false
      }]
    },
    options: {
      legend: {
        labels: {
          fontSize: 12
        }
      }
    }
  });
}



function aiBot(prompt) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: 'https://uc-chatbot-v2.onrender.com',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify({
        prompt: prompt
      }),
      success: function(data) {
        const botMessage = data.bot.trim();
        resolve(botMessage);
      },
      error: function(error) {
        reject(error);
      }
    });
  });
}

function aiCall() {
  $('#recommendationsTable').empty();
  var rowDataArray = [];

  $('#resultsTable tbody tr').each(function() {
    var rowData = [];

    $(this).find('td').each(function(index) {
      if (index === 0 || index === 2) {
        rowData.push($(this).text());
      }
    });

    rowDataArray.push(rowData);
  });

  aiBot(`The list below is a list of transactions. In each transaction there are two values. 
  The first value is the item name and the second value is the amount sold, for example: [["Snow Bear","12"],["Snow Bear","12"],["Coke","64"]]. 
  I want you to read each transacation and compile item with similar names and add each amount sold. Check each amount and add them step by step and accurately to get the correct result. 
  For example, in this given transaction list [["Coke","14"],["Snow Bear","13"],["Snow Bear","12"],["Coke","64"],["Snow Bear","42"]]
  you will create a summary of amount sold in this format: [["Snow Bear","67"],["Coke","78"]]. \nList:` + JSON.stringify(rowDataArray))
  .then(function(response) {
    const responses = JSON.parse(response);
    $newElement = $('<tbody></tbody>');
    responses.forEach(function(res) {
      console.log(res);
      $newElement.append('<tr><td style="width: 50%; padding-left: 10px; border-right: 1px solid #4CAF50;">'+res[0]+'</td><td style="width: 50%; padding-left: 10px;">'+res[1]+'</td></tr>')
    })
    $('#recommendationsTable').append('<thead><tr><td colspan="2"><h4 style="padding: 10px; margin-bottom: 0; border-bottom: 1px solid #4CAF50;">Items to Replenish (Table)</h4></td></tr><tr><td style="width: 50%; text-align: center; border-bottom: 1px solid #4CAF50; border-right: 1px solid #4CAF50;">Item Name</td><td style="width: 50%; text-align: center; border-bottom: 1px solid #4CAF50;">Item Amount to Replenish</td></tr></thead>')
    $('#recommendationsTable').append($newElement);
    myButton.text('Generate Grocery List');
      myButton.prop('disabled',false);
  })
  .catch(function(error) {
    console.error(error);
  });

}