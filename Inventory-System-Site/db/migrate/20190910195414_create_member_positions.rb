class CreateMemberPositions < ActiveRecord::Migration
  def change
    create_table :member_positions do |t|
      t.integer :id
      t.string :position
      t.integer :privilege
      t.text :description
      t.boolean :removed
      t.timestamp :created_at
      t.timestamp :updated_at

      t.timestamps null: false
    end
  end
end
