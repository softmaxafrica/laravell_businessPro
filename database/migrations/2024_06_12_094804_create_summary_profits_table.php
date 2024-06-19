<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW summary_profits AS
            SELECT
                b.owner AS owner,
                b.name AS business_name,
                u.email AS user_email,
                COALESCE(s.date, e.date_of_transaction) AS date,
                SUM(s.total_price) AS total_sales,
                COALESCE(SUM(e.amount_used), 0) AS total_expenses,
                b.expected_profit / b.business_period_days AS daily_target,
                SUM(s.total_profit) AS total_profit,
                (SUM(s.total_profit) - COALESCE(SUM(e.amount_used), 0)) AS net_day_profit,
                (SUM(s.total_profit) - (b.expected_profit / b.business_period_days)) AS deviation
            FROM
                businesses b
            LEFT JOIN
                (
                    SELECT
                        owner,
                        DATE(date_of_transaction) AS date,
                        SUM(total_profit) AS total_profit,
                        SUM(total_price) AS total_price
                    FROM
                        sales
                    GROUP BY
                        owner, DATE(date_of_transaction)
                ) s ON b.owner = s.owner
            LEFT JOIN
                expenses e ON b.owner = e.user_email AND DATE(e.date_of_transaction) = COALESCE(s.date, DATE(e.date_of_transaction))
            LEFT JOIN
                users u ON b.owner = u.email
            GROUP BY
                b.owner, b.name, u.email, COALESCE(s.date, e.date_of_transaction), b.expected_profit, b.business_period_days
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS summary_profits");
    }
};
