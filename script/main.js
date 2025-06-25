document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("person-form");
  const tableBody = document.getElementById("person-table");
  const searchInput = document.getElementById("search");
  const baseUrl = "server/person-handler.php";

  function fetchData(query = "") {
    const url = query
      ? `${baseUrl}?action=search&q=${query}`
      : `${baseUrl}?action=read`;
    fetch(url)
      .then((res) => res.json())
      .then(renderTable);
  }

  function renderTable(data) {
    tableBody.innerHTML = "";
    data.forEach((row) => {
      tableBody.innerHTML += `
      <tr>
        <td data-label="Name">${row.name}</td>
        <td data-label="Age">${row.age}</td>
        <td data-label="Gender">${row.gender}</td>
        <td data-label="Created At">${row.created_at}</td>
        <td data-label="Actions">
          <button onclick="editData(${row.id}, '${row.name}', ${row.age}, '${row.gender}')">Edit</button>
          <button onclick="deleteData(${row.id})">Delete</button>
        </td>
      </tr>`;
    });
  }

  form.onsubmit = (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const isUpdate = formData.get("id");
    const action = isUpdate ? "update" : "create";

    fetch(`${baseUrl}?action=${action}`, {
      method: "POST",
      body: formData,
    }).then(() => {
      form.reset(); // clear all fields
      form.id.value = ""; // FIX: clear the hidden ID field manually
      fetchData();
    });
  };

  searchInput.oninput = () => fetchData(searchInput.value);

  window.editData = (id, name, age, gender) => {
    form.id.value = id;
    form.name.value = name;
    form.age.value = age;
    form.gender.value = gender;
  };

  window.deleteData = (id) => {
    const formData = new FormData();
    formData.append("id", id);
    fetch(`${baseUrl}?action=delete`, {
      method: "POST",
      body: formData,
    }).then(() => fetchData());
  };

  fetchData();
});
