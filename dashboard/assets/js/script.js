const API_URL = 'http://localhost/kontak-pribadi/api.php';
let contacts = [];
let isEditing = false;

// Fetch all contacts
async function fetchContacts() {
    try {
        const response = await fetch(API_URL);
        contacts = await response.json();
        displayContacts();
    } catch (error) {
        console.error('Error:', error);
        alert('Error fetching contacts');
    }
}

// Display contacts in table
function displayContacts() {
    const contactList = document.getElementById('contactList');
    contactList.innerHTML = '';

    contacts.forEach(contact => {
        const row = document.createElement('tr');
        row.innerHTML = `
                    <td>${contact.name}</td>
                    <td>${contact.email}</td>
                    <td>${contact.phone || '-'}</td>
                    <td>${contact.address || '-'}</td>
                    <td>
                        <button onclick="editContact(${contact.id})" class="action-btn edit-btn">Edit</button>
                        <button onclick="deleteContact(${contact.id})" class="action-btn delete-btn">Delete</button>
                    </td>
                `;
        contactList.appendChild(row);
    });
}

// Handle form submission
document.getElementById('contactForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const contactData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value
    };

    if (isEditing) {
        contactData.id = document.getElementById('contactId').value;
        await updateContact(contactData);
    } else {
        await createContact(contactData);
    }

    resetForm();
    fetchContacts();
});

// Create new contact
async function createContact(contactData) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(contactData)
        });

        if (!response.ok) {
            throw new Error('Error creating contact');
        }

        alert('Contact created successfully');
    } catch (error) {
        console.error('Error:', error);
        alert('Error creating contact');
    }
}

// Load contact data into form for editing
function editContact(id) {
    const contact = contacts.find(c => c.id == id);
    if (contact) {
        document.getElementById('contactId').value = contact.id;
        document.getElementById('name').value = contact.name;
        document.getElementById('email').value = contact.email;
        document.getElementById('phone').value = contact.phone || '';
        document.getElementById('address').value = contact.address || '';

        document.getElementById('formTitle').textContent = 'Edit Contact';
        document.getElementById('submitBtn').textContent = 'Update Contact';
        isEditing = true;
    }
}

// Update existing contact
async function updateContact(contactData) {
    try {
        const response = await fetch(API_URL, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(contactData)
        });

        if (!response.ok) {
            throw new Error('Error updating contact');
        }

        alert('Contact updated successfully');
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating contact');
    }
}

// Delete contact
async function deleteContact(id) {
    if (confirm('Are you sure you want to delete this contact?')) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE'
            });

            if (!response.ok) {
                throw new Error('Error deleting contact');
            }

            alert('Contact deleted successfully');
            fetchContacts();
        } catch (error) {
            console.error('Error:', error);
            alert('Error deleting contact');
        }
    }
}

// Reset form to initial state
function resetForm() {
    document.getElementById('contactForm').reset();
    document.getElementById('contactId').value = '';
    document.getElementById('formTitle').textContent = 'Add New Contact';
    document.getElementById('submitBtn').textContent = 'Add Contact';
    isEditing = false;
}

// Initial load
fetchContacts();