package main

type CoffeeCatalog struct {
	Items []Coffee `xml:"item"`
}

type Coffee struct {
	Id int `xml:"entity_id" json:"entityId"`
	CategoryName string `xml:"CategoryName" json:"categoryName"`
	Sku int `xml:"sku" json:"sku"`
	Name string `xml:"name" json:"name"`
	Description string `xml:"description" json:"description"`
	Price float32 `xml:"price" json:"price"`
	Link string `xml:"link" json:"link"`
	ImageSource string `xml:"image" json:"image"`
}
