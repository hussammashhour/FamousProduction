# Famous Production Design System

A comprehensive design system built with Vue 3, Inertia.js, and Tailwind CSS for the Famous Production application.

## 🎨 Design Tokens

### Color Palette

#### Primary Colors (Blue)
- **primary-50** to **primary-950**: A complete blue color scale
- **Usage**: Primary actions, links, and brand elements
- **Example**: `bg-primary-600`, `text-primary-500`, `border-primary-200`

#### Secondary Colors (Gray)
- **secondary-50** to **secondary-950**: A complete gray color scale
- **Usage**: Text, backgrounds, borders, and neutral elements
- **Example**: `bg-secondary-100`, `text-secondary-600`, `border-secondary-300`

#### Semantic Colors
- **Success**: `success-500` - Green for positive actions
- **Warning**: `warning-500` - Yellow for caution
- **Error**: `error-500` - Red for errors and destructive actions
- **Accent**: `accent-500` - Purple for highlights and special elements

### Typography

#### Font Families
- **Headings**: `font-heading` (Poppins)
- **Body**: `font-sans` (Inter)
- **Code**: `font-mono` (JetBrains Mono)

#### Font Sizes
- **Responsive**: `text-responsive-*` classes that scale with screen size
- **Fixed**: `text-xs` to `text-9xl`
- **Example**: `text-responsive-lg` scales from `text-lg` on mobile to `text-xl` on larger screens

### Spacing
- **Responsive spacing**: `space-responsive`, `gap-responsive`
- **Custom spacing**: `space-18`, `space-88`, `space-128`

### Breakpoints (Mobile-First)
- **xs**: 475px
- **sm**: 640px
- **md**: 768px
- **lg**: 1024px
- **xl**: 1280px
- **2xl**: 1536px

## 🧩 Components

### BaseButton

A versatile button component with multiple variants, sizes, and states.

```vue
<BaseButton 
  variant="primary" 
  size="md" 
  :loading="false" 
  :disabled="false"
  @click="handleClick"
>
  Click Me
</BaseButton>
```

#### Props
- **variant**: `primary` | `secondary` | `outline` | `ghost` | `danger` | `success`
- **size**: `sm` | `md` | `lg` | `xl`
- **loading**: Boolean - Shows spinner and disables button
- **disabled**: Boolean - Disables the button
- **fullWidth**: Boolean - Makes button full width

#### Examples
```vue
<!-- Different variants -->
<BaseButton variant="primary">Primary</BaseButton>
<BaseButton variant="secondary">Secondary</BaseButton>
<BaseButton variant="outline">Outline</BaseButton>
<BaseButton variant="ghost">Ghost</BaseButton>
<BaseButton variant="danger">Danger</BaseButton>
<BaseButton variant="success">Success</BaseButton>

<!-- Different sizes -->
<BaseButton size="sm" variant="primary">Small</BaseButton>
<BaseButton size="md" variant="primary">Medium</BaseButton>
<BaseButton size="lg" variant="primary">Large</BaseButton>
<BaseButton size="xl" variant="primary">Extra Large</BaseButton>

<!-- States -->
<BaseButton variant="primary" loading>Loading</BaseButton>
<BaseButton variant="primary" disabled>Disabled</BaseButton>
```

### BaseCard

A flexible card component with header, body, and footer sections.

```vue
<BaseCard 
  padding="normal" 
  shadow="soft" 
  :hover="false"
>
  <template #header>
    <h3>Card Header</h3>
  </template>
  
  <p>Card content goes here</p>
  
  <template #footer>
    <BaseButton variant="primary">Action</BaseButton>
  </template>
</BaseCard>
```

#### Props
- **padding**: `none` | `small` | `normal` | `large`
- **shadow**: `none` | `soft` | `medium` | `strong`
- **hover**: Boolean - Adds hover lift effect

#### Examples
```vue
<!-- Basic card -->
<BaseCard>
  <h3>Simple Card</h3>
  <p>Content here</p>
</BaseCard>

<!-- Card with header and footer -->
<BaseCard>
  <template #header>
    <h3>Card Title</h3>
  </template>
  <p>Card body content</p>
  <template #footer>
    <div class="flex justify-end">
      <BaseButton variant="primary">Save</BaseButton>
    </div>
  </template>
</BaseCard>

<!-- Hover card -->
<BaseCard hover>
  <h3>Hover Card</h3>
  <p>This card lifts on hover</p>
</BaseCard>
```

### BaseInput

A form input component with validation states and icons.

```vue
<BaseInput
  v-model="email"
  type="email"
  label="Email Address"
  placeholder="Enter your email"
  :error="emailError"
  help="We'll never share your email"
  required
/>
```

#### Props
- **modelValue**: String/Number - Input value (v-model)
- **type**: String - Input type (text, email, password, etc.)
- **label**: String - Input label
- **placeholder**: String - Placeholder text
- **error**: String - Error message
- **help**: String - Help text
- **required**: Boolean - Shows required indicator
- **disabled**: Boolean - Disables the input
- **icon**: Component - Icon to display

#### Examples
```vue
<!-- Basic input -->
<BaseInput
  v-model="name"
  label="Name"
  placeholder="Enter your name"
/>

<!-- Input with error -->
<BaseInput
  v-model="email"
  type="email"
  label="Email"
  error="Please enter a valid email address"
/>

<!-- Input with help text -->
<BaseInput
  v-model="phone"
  type="tel"
  label="Phone"
  help="We'll use this to contact you"
/>

<!-- Required input -->
<BaseInput
  v-model="username"
  label="Username"
  required
/>
```

### Navbar

A responsive navigation component with mobile menu and user dropdown.

```vue
<Navbar />
```

#### Features
- Responsive design with mobile hamburger menu
- User profile dropdown
- Active link highlighting
- Logo and branding
- Notification bell (placeholder)

## 🎯 Utility Classes

### Responsive Text
```css
.text-responsive-xs   /* xs: text-xs, sm+: text-sm */
.text-responsive-sm   /* xs: text-sm, sm+: text-base */
.text-responsive-base /* xs: text-base, sm+: text-lg */
.text-responsive-lg   /* xs: text-lg, sm+: text-xl */
.text-responsive-xl   /* xs: text-xl, sm+: text-2xl */
.text-responsive-2xl  /* xs: text-2xl, sm+: text-3xl */
.text-responsive-3xl  /* xs: text-3xl, sm+: text-4xl */
```

### Responsive Spacing
```css
.space-responsive  /* xs: space-y-4, sm+: space-y-6, md+: space-y-8 */
.gap-responsive    /* xs: gap-4, sm+: gap-6, md+: gap-8 */
```

### Layout Utilities
```css
.container-responsive  /* Responsive container with max-width and padding */
.section              /* Standard section padding */
.grid-responsive      /* Responsive grid with gap scaling */
```

### Effects
```css
.hover-lift    /* Hover transform and shadow */
.hover-scale   /* Hover scale effect */
.glass         /* Glass morphism effect */
.text-gradient /* Gradient text effect */
```

### Animations
```css
.animate-fade-in     /* Fade in animation */
.animate-slide-up    /* Slide up animation */
.animate-slide-down  /* Slide down animation */
.animate-scale-in    /* Scale in animation */
```

## 📱 Responsive Design Patterns

### Mobile-First Approach
All components and utilities follow a mobile-first approach. Start with mobile styles and enhance for larger screens.

### Breakpoint Strategy
```css
/* Mobile first - base styles */
.element {
  /* Mobile styles */
}

/* Small screens and up */
@media (min-width: 640px) {
  .element {
    /* Small screen enhancements */
  }
}

/* Medium screens and up */
@media (min-width: 768px) {
  .element {
    /* Medium screen enhancements */
  }
}
```

### Grid System
```vue
<!-- Responsive grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
  <div>Item 1</div>
  <div>Item 2</div>
  <div>Item 3</div>
  <div>Item 4</div>
</div>
```

### Typography Scaling
```vue
<!-- Responsive heading -->
<h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl">
  Responsive Heading
</h1>

<!-- Or use utility class -->
<h1 class="text-responsive-3xl">
  Responsive Heading
</h1>
```

## 🎨 CSS Classes Reference

### Button Classes
```css
.btn              /* Base button styles */
.btn-primary      /* Primary button variant */
.btn-secondary    /* Secondary button variant */
.btn-outline      /* Outline button variant */
.btn-ghost        /* Ghost button variant */
.btn-danger       /* Danger button variant */
.btn-success      /* Success button variant */
.btn-sm           /* Small button size */
.btn-lg           /* Large button size */
.btn-xl           /* Extra large button size */
```

### Card Classes
```css
.card             /* Base card styles */
.card-header      /* Card header section */
.card-body        /* Card body section */
.card-footer      /* Card footer section */
```

### Form Classes
```css
.form-input       /* Input field styles */
.form-label       /* Label styles */
.form-error       /* Error message styles */
.form-help        /* Help text styles */
```

### Badge Classes
```css
.badge            /* Base badge styles */
.badge-primary    /* Primary badge variant */
.badge-secondary  /* Secondary badge variant */
.badge-success    /* Success badge variant */
.badge-warning    /* Warning badge variant */
.badge-error      /* Error badge variant */
```

### Alert Classes
```css
.alert            /* Base alert styles */
.alert-info       /* Info alert variant */
.alert-success    /* Success alert variant */
.alert-warning    /* Warning alert variant */
.alert-error      /* Error alert variant */
```

## 🚀 Getting Started

1. **Start the development servers**:
   ```bash
   # Backend
   php artisan serve
   
   # Frontend
   npm run dev
   ```

2. **View the design system**:
   Visit `http://localhost:8000/design-system` to see all components in action.

3. **Use components in your pages**:
   ```vue
   <script setup>
   import BaseButton from '@/components/UI/BaseButton.vue'
   import BaseCard from '@/components/UI/BaseCard.vue'
   import BaseInput from '@/components/UI/BaseInput.vue'
   </script>
   ```

## 📝 Best Practices

1. **Use semantic colors**: Use `success`, `warning`, `error` for their intended purposes
2. **Mobile-first**: Always start with mobile styles and enhance for larger screens
3. **Consistent spacing**: Use the provided spacing utilities for consistency
4. **Accessibility**: All components include proper focus states and ARIA attributes
5. **Performance**: Use utility classes over custom CSS when possible
6. **Maintainability**: Use the component system for reusable UI elements

## 🔧 Customization

### Adding New Colors
Add to `tailwind.config.js`:
```javascript
colors: {
  custom: {
    50: '#f0f9ff',
    // ... other shades
    900: '#0c4a6e',
  }
}
```

### Adding New Components
1. Create component in `resources/js/components/UI/`
2. Add to design system page for documentation
3. Update this documentation

### Adding New Utilities
Add to `resources/css/app.css` in the appropriate layer:
```css
@layer utilities {
  .custom-utility {
    /* styles */
  }
}
```

## 📚 Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Laravel Documentation](https://laravel.com/docs) 
