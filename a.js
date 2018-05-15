let tags = [
  {
    name: 'a',
    id: 1
  },
  {
    name: 'b',
    id: 2
  },
  {
    name: 'c',
    id: 3
  }
];

let rs = [];
tags.forEach(function (v,i,array) {
  rs.push(v.name);
});

console.log(rs);

