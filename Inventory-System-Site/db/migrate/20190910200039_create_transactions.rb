class CreateTransactions < ActiveRecord::Migration
  def change
    create_table :transactions do |t|
      t.integer :member_id
      t.integer :item_id
      t.integer :item_change_quantity
      t.timestamp :created_at
      t.text :comment

      t.timestamps null: false
    end
  end
end
