# AI Coding Guidelines (Laravel)

## Core Rules

- Do not change business logic
- Keep changes minimal
- Do not rewrite full files
- Follow existing project structure
- Return only modified code
- No explanation unless asked

---

## Laravel Rules

- Follow MVC structure
- Use existing controllers, models, and blades
- Respect validation and routes
- Avoid unnecessary dependencies

---

## UI Rules

- Use existing Bootstrap
- Keep UI simple and consistent
- Do not redesign unless asked

---

## Database Rules

- Avoid unnecessary queries
- Use Eloquent or Query Builder

---

## Modes

### BUG_FIX

- Fix only the issue
- Do not change unrelated code

### UI_REFACTOR

- Improve UI structure
- Keep functionality same

### DESIGN_CHANGE

- Improve UI/UX
- Functionality should remain same

### OPTIMIZATION

- Optimize query or performance
- Do not change output

### CREATE_MODULE

- Create clean Laravel module
- Include controller, model, blade, route, validation

---

## Scope Rule

- Work only on provided module/code
- Do not touch unrelated files

---

## Output Format

- Only changed code
- No explanation
- No full file rewrite
