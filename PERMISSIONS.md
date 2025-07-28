# Role-Based Access Control (RBAC) System

## User Roles Overview

### 1. Super Admin
- **Full access** to all system features and data
- Can manage all resources, users, and system settings
- Can permanently delete any data
- Can manage roles and permissions
- Access to all dashboard widgets and analytics

### 2. Admin
- **Full access** to most business operations
- Cannot access support tickets and technical issues
- Cannot manage roles (only super admin can)
- Can manage users, services, bookings, payments, content
- Access to business-focused dashboard widgets

### 3. Technician
- **Limited access** focused on technical support
- Can manage support tickets and technical issues
- Cannot access business operations (bookings, payments, etc.)
- Cannot manage users or roles
- Access to support-focused dashboard widgets

### 4. Photographer
- **Content-focused access**
- Can manage posts, photos, services, bookings
- Can manage tags and attachments
- Cannot access user management, payments, or support
- Access to content-focused dashboard widgets

### 5. User (Regular User)
- **No dashboard access**
- Can only access the public website
- Can create bookings, reviews, comments, likes
- Cannot access any admin panel features

## Detailed Permissions by Resource

### User Management
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations (except cannot delete themselves)
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Role Management
- **Super Admin**: Full CRUD operations
- **Admin**: No access
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Services
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: Full CRUD operations
- **User**: No access

### Bookings
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: Full CRUD operations (can manage their bookings)
- **User**: No access

### Payments
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Posts
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: Full CRUD operations (can manage their posts)
- **User**: No access

### Photos
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: Full CRUD operations (can manage their photos)
- **User**: No access

### Reviews
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Announcements
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Support Tickets
- **Super Admin**: Full CRUD operations
- **Admin**: No access
- **Technician**: Full CRUD operations
- **Photographer**: No access
- **User**: No access

### FAQs
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Tags
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: Full CRUD operations
- **User**: No access

### Messages
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Comments
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Likes
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: No access
- **User**: No access

### Attachments
- **Super Admin**: Full CRUD operations
- **Admin**: Full CRUD operations
- **Technician**: No access
- **Photographer**: Full CRUD operations
- **User**: No access

## Dashboard Access

### Super Admin Dashboard
- All widgets and analytics
- User management overview
- System-wide statistics
- Support ticket overview
- Business metrics

### Admin Dashboard
- Business-focused widgets
- User management (excluding roles)
- Service and booking analytics
- Payment tracking
- Content management overview
- **Excludes**: Support tickets, technical issues

### Technician Dashboard
- Support-focused widgets
- Support ticket management
- Technical issue tracking
- **Excludes**: Business operations, user management

### Photographer Dashboard
- Content-focused widgets
- Photo and post management
- Booking management (their bookings)
- Service management
- **Excludes**: User management, payments, support

## Implementation Notes

1. **Policies**: All resources have corresponding policies that enforce these permissions
2. **User Model**: Contains helper methods for role checking and permission validation
3. **Filament Resources**: Automatically respect these policies
4. **Dashboard Widgets**: Filtered based on user permissions
5. **Navigation**: Dynamically shows/hides menu items based on permissions

## Security Features

- **Role-based access control** at the policy level
- **Resource-level permissions** for fine-grained control
- **User ownership validation** for personal data
- **Hierarchical permissions** (super admin > admin > technician > photographer > user)
- **Automatic policy enforcement** through Laravel's authorization system 
