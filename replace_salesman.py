import os

files = [
    r'application/controllers/Salesman.php',
    r'application/models/Salesman_model.php',
    r'application/views/salesman.php',
    r'application/views/salesman-view.php'
]

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Precise replacements
    content = content.replace('Customers_model', 'Salesman_model')
    content = content.replace('Customers', 'Salesman')
    content = content.replace('customers', 'salesman')
    content = content.replace('Customer', 'Salesman')
    content = content.replace('customer', 'salesman')
    content = content.replace('db_salesmans', 'db_salesman') # fix plural issues if any
    content = content.replace('salesmans', 'salesman') # fix plural issues if any
    
    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)

print("Replacement complete.")
