
fetchTrackings();


document.getElementById('tracking-form').onsubmit = function (e) {
    e.preventDefault();
    create_tracking();
    location.reload();
    return false;
};

document.getElementById('update-tracking-form').onsubmit = function (e) {
    e.preventDefault()
    updateTracking(e)
    location.reload();
    return false;
}

//Create new Tracking
function create_tracking() {
    const receiverName = document.getElementById("receiver-name").value;
    const receiverAddress = document.getElementById("receiver-address").value;
    const receiverEmail = document.getElementById("receiver-email").value;
    const receiverPhone = document.getElementById("receiver-phone").value;
    const origin = document.getElementById("origin").value;
    const destination = document.getElementById("destination").value;
    const shipperName = document.getElementById("shipper-name").value;
    const shipperPhone = document.getElementById("shipper-phone").value;
    const shipperEmail = document.getElementById("shipper-email").value;
    const current_location = document.getElementById("current-location").value;
    const product = document.getElementById("product").value;
    const weight = document.getElementById("weight").value;
    const shippingStatus = document.getElementById("shipping-status").value;
    const release_date = document.getElementById("release-date").value;
    const delivery_date = document.getElementById("delivery-date").value;
    const track = {
        product: product,
        release_date: release_date,
        delivery_date: delivery_date,
        origin: origin,
        receiver_name: receiverName,
        receiver_address: receiverAddress,
        receiver_phone: receiverPhone,
        destination: destination,
        current_location: current_location,
        status: shippingStatus,
        receiver_email: receiverEmail,
        shipper_name: shipperName,
        shipper_email: shipperEmail,
        shipper_phone: shipperPhone,
        weight: weight
    }

    //Options for fetch API call
    const options = {
        method: 'POST',
        body: JSON.stringify(track),
        headers: {
            'Content-Type': 'application/json'
        }
    }

    fetch('http://localhost/cargo/backend/tracking/create.php', options)
        .then(res => {
            if (res.ok) {
                return res.json();
            } else {
                return Promise.reject({ status: res.status, statusText: res.statusText })
            }
        })
        .then(res => {
            $("#trackingModal").modal("hide");
        }).catch(err => {
            console.log(err)
        });
}




//On page load  Fetch all Trackings and fill table
function fetchTrackings() {
    fetch('http://localhost/cargo/backend/tracking/read.php')
        .then(res => {
            if (res.ok) {
                return res.json();
            } else {
                return Promise.reject({ status: res.status, statusText: res.statusText })
            }
        })
        .then(res => {
            const data = res.data;
            data.map((track) => {
                const tr = document.createElement("tr");
                tr.innerHTML = "<td>" + track["tracking_number"] + "</td>" +
                    "<td>" + track["origin"] + "</td>" +
                    "<td>" + track["delivery_date"] + "</td>" +
                    "<td>" + track["product"] + "</td>" +
                    "<td>" + track["destination"] + "</td>" +
                    "<td>" + track["receiver_email"] + "</td>" +
                    "<td>" + track["receiver_name"] + "</td>" +
                    "<td>" + track["receiver_address"] + "</td>" +
                    "<td>" + track["receiver_phone"] + "</td>" +
                    "<td>" + track["current_location"] + "</td>" +
                    "<td>" + track["shipping_status"] + "</td>" +
                    "<td><button class='btn btn-secodary edit-btn'  data-trackid=" + track["tracking_number"] + " data-id="+track["id"]+">Edit</button></td>" +
                    "<td><button class='btn btn-danger delete-btn'  data-trackid=" + track["tracking_number"] + " data-id="+ track["id"]+">Delete</button></td>"
                document.getElementById('tbody').appendChild(tr);

                const editBtns = document.querySelectorAll('.edit-btn');
                for (let i = 0; i < editBtns.length; i++) {
                    const btn = editBtns[i];
                    btn.addEventListener('click', fetchAndFillModal)
                }
            })
        }).catch(err => {
            console.log(err)
        })
}

function updateTracking(e) {
    const receiverName = document.getElementById("ureceiver-name").value;
    const receiverAddress = document.getElementById("ureceiver-address").value;
    const receiverEmail = document.getElementById("ureceiver-email").value;
    const receiverPhone = document.getElementById("ureceiver-phone").value;
    const origin = document.getElementById("uorigin").value;
    const destination = document.getElementById("udestination").value;
    const shipperName = document.getElementById("ushipper-name").value;
    const shipperPhone = document.getElementById("ushipper-phone").value;
    const shipperEmail = document.getElementById("ushipper-email").value;
    const current_location = document.getElementById("ucurrent-location").value;
    const product = document.getElementById("uproduct").value;
    const weight = document.getElementById("uweight").value;
    const shippingStatus = document.getElementById("ushipping-status").value;
    const release_date = document.getElementById("urelease-date").value;
    const delivery_date = document.getElementById("udelivery-date").value;
    const tracking_number = document.getElementById("tracking_number").value;
    const id = document.getElementById("tracking_id").value;

    console.log(tracking_number +" Hello How");

    const track = {
        id: id,
        product: product,
        release_date: release_date,
        delivery_date: delivery_date,
        tracking_number: tracking_number,
        origin: origin,
        receiver_name: receiverName,
        receiver_address: receiverAddress,
        receiver_phone: receiverPhone,
        destination: destination,
        current_location: current_location,
        status: shippingStatus,
        receiver_email: receiverEmail,
        shipper_name: shipperName,
        shipper_email: shipperEmail,
        shipper_phone: shipperPhone,
        weight: weight
    }

    //Options for fetch API call
    const options = {
        method: 'PUT',
        body: JSON.stringify(track),
        headers: {
            'Content-Type': 'application/json'
        }
    }

    fetch('http://localhost/cargo/backend/tracking/update.php', options)
        .then(res => {
            if (res.ok) {
                return res.json();
            } else {
                return Promise.reject({ status: res.status, statusText: res.statusText })
            }
        })
        .then(res => {
                $("#updateModal").modal("hide");
        }).catch(err => {
            console.log(err)
            $("#updateModal").modal("hide");
        });
    
}

function fetchAndFillModal(e) {
    const tracking_no = e.target.dataset['trackid'];
    fetch('http://localhost/cargo/backend/tracking/readsingle.php?tracking_number=' + tracking_no)
        .then(res => {
            if (res.ok) {
                return res.json();
            } else {
                return Promise.reject({ status: res.status, statusText: res.statusText })
            }
        })
        .then(res => {
            const data = res.data;
            document.getElementById("ureceiver-name").value = data["receiver_name"];
            document.getElementById("ureceiver-address").value  = data["receiver_address"];
            document.getElementById("ureceiver-email").value = data["receiver_email"];
            document.getElementById("ureceiver-phone").value = data["receiver_phone"];
            document.getElementById("uorigin").value = data["origin"];
            document.getElementById("udestination").value = data["destination"];
            document.getElementById("ushipper-name").value = data["shipper_name"];
            document.getElementById("ushipper-phone").value = data["shipper_phone"];
            document.getElementById("ushipper-email").value = data["shipper_email"];
            document.getElementById("ucurrent-location").value = data["current_location"];
            document.getElementById("uproduct").value = data["product"];
            document.getElementById("uweight").value = data["weight"];
            document.getElementById("ushipping-status").value = data["shipping_status"];
            document.getElementById("urelease-date").value = data["release_date"];
            document.getElementById("udelivery-date").value = data["delivery_date"];
            document.getElementById("tracking_number").value = data["tracking_number"];
            document.getElementById("tracking_id").value = data["id"];
            $("#updateModal").modal("show");

        }).catch(err => {
            console.log(err);
        })
}

function fetchsingle(tracking_number) {
    fetch('http://localhost/cargo/backend/tracking/readsingle.php?tracking_number=' + tracking_number)
        .then(res => {
            if (res.ok) {
                return res.json();
            } else {
                return Promise.reject({ status: res.status, statusText: res.statusText })
            }
        })
        .then(res => {
            const data = res.data;
            console.log(data)
        }).catch(err => {
            console.log(err);
        })
}
