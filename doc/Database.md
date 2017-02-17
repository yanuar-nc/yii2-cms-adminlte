# Database

This template have some rules.

## Tables
- Actions
- Menus
- Roles
- Roles Menus
- Users

## Obligation Fields
- id (INT) 			--> Primary Key
- row_status (INT)  --> Row status have range (1, 0, -1) it means ('Active', 'Disactive', 'Delete')
- created_at (INT)  --> Created at date by timestamp
- created_by (INT)  --> Owner rows
- updated_at (INT)  --> Updated at date by timestamp
- updated_by (INT)  --> Owner update rows

## Primary Key
we suggest you to give name of primary key is `id`
