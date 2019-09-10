class CreateMembers < ActiveRecord::Migration
  def change
    create_table :members do |t|
      t.integer :id
      t.string :first_name
      t.string :last_name
      t.integer :member_position_id
      t.string :phone_num
      t.string :email
      t.string :username
      t.string :password
      t.boolean :curr_member
      t.timestamp :created_at
      t.timestamp :updated_at

      t.timestamps null: false
    end
  end
end
