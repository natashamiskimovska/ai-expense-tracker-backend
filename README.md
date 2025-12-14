# Laravel AI Expense Tracker

A Laravel 11 project to manage personal expenses with **AI-powered analysis and savings prediction**. Users can track expenses, categorize them, and get insights on unusual spending and potential savings.

---

## Features

- **Expense Management**
  - Add, edit, delete, and view expenses.
  - Assign categories to expenses.

- **AI Analysis**
  - Detect unusual spending patterns.
  - Generate JSON reports including:
    - Total spent
    - Top spending categories
    - Alerts for high/abnormal expenses
    - Predicted savings based on cost-cutting suggestions.

- **User Authentication**
  - Secure registration and login.
  - Each user can only access their own expenses.

- **API-First**
  - JSON responses for frontend integration.
  - Ready for mobile or web apps.

---

## Installation

1. **Clone the repository**

```bash
git clone [https://github.com/natashamiskimovska/ai-expense-tracker-backend.git]
```
2. **Install Dependencies**
```bash
composer install
```
3. **Set environment Variables**
- Database credentials (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- OpenAI API key (OPENAI_API_KEY)
