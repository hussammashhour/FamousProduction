# Test User Credentials

All test users use the password: **123123123**

## Admin Panel Access Users

### Super Admin
- **Email**: superadmin@famousproduction.lb
- **Password**: 123123123
- **Access**: Full system access (all resources, roles, support tickets)

### Admin
- **Email**: admin@famousproduction.lb
- **Password**: 123123123
- **Access**: Business operations (no support tickets, no role management)

### Technician
- **Email**: technician@famousproduction.lb
- **Password**: 123123123
- **Access**: Support tickets and technical issues only

### Photographer
- **Email**: photographer@famousproduction.lb
- **Password**: 123123123
- **Access**: Content management (posts, photos, services, bookings, tags)

## Additional Test Users

### Additional Photographers
- photographer2@famousproduction.lb
- photographer3@famousproduction.lb
- photographer4@famousproduction.lb

### Additional Technicians
- technician2@famousproduction.lb
- technician3@famousproduction.lb

### Regular Users (No Admin Access)
- user@famousproduction.lb
- user1@famousproduction.lb
- user2@famousproduction.lb
- user3@famousproduction.lb
- user4@famousproduction.lb
- user5@famousproduction.lb
- user6@famousproduction.lb
- user7@famousproduction.lb
- user8@famousproduction.lb
- user9@famousproduction.lb
- user10@famousproduction.lb

## Testing Scenarios

### 1. Super Admin Testing
- Login with: superadmin@famousproduction.lb
- Should see all resources and widgets
- Can manage roles and users
- Can access support tickets

### 2. Admin Testing
- Login with: admin@famousproduction.lb
- Should see business resources (no support tickets)
- Cannot manage roles
- Can manage users, services, bookings, payments

### 3. Technician Testing
- Login with: technician@famousproduction.lb
- Should only see support tickets and technical resources
- Cannot access business operations
- Cannot manage users or roles

### 4. Photographer Testing
- Login with: photographer@famousproduction.lb
- Should see content management resources
- Can manage posts, photos, services, bookings
- Cannot access user management or payments

### 5. Regular User Testing
- Login with: user@famousproduction.lb
- Should NOT be able to access admin panel
- Can only access public website features

## User Distribution

- **Super Admin**: 1 user
- **Admin**: 1 user  
- **Technician**: 3 users (main + 2 additional)
- **Photographer**: 4 users (main + 3 additional)
- **Regular User**: 11 users (main + 10 additional)

**Total**: 20 test users

## Quick Test Commands

```bash
# Reset and seed database with test users
php artisan migrate:fresh --seed

# Clear caches after changes
php artisan config:clear
php artisan cache:clear
```

## Notes

- All users are created with verified email addresses
- All users have Lebanese phone numbers (+961 format)
- All users have Beirut coordinates (33.8935, 35.5018)
- Users are created with realistic names and addresses
- The system enforces role-based permissions automatically
- Each user type has unique phone numbers to avoid conflicts
