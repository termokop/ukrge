let func = {
    translit(str,lang) {
        let x = true
        if(x) return str
        let orig = [], trans = []
        if (lang === 'ua') {
            orig = ['ა','ბ','გ','დ','ე','ვ','ზ','თ','ი','კ','ლ','მ','ნ','ო','პ','ჟ','რ','ს','ტ','უ','ფ','ქ','ღ','ყ','შ','ჩ','ც','ძ','წ','ჭ','ხ','ჯ','ჰ']
            trans = ['а','б','ґ','д','е','в','з','т*','і','к','л','м','н','о','п','ж','р','с','т','у','п','к*','г','к','ш','ч','ц','дз','тц','тч','х','дж','х'] 
        } else if (lang === 'ge') {
            orig = ['а','б','в','г','ґ','д','е','є','ж','з','и','і','ї','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ю','я']
            trans = ['ა','ბ','ვ','ღ','გ','დ','ე','იე','ჟ','ზ','ი*','ი','იი','ი','კ','ლ','მ','ნ','ო','პ','რ','ს','ტ','უ','ფ*','ხ','ც','ჩ','შ','შჩ','ი**','იუ','ია']

        }
        
        
        str = str.toLowerCase()
        if(!orig.includes(str[0].toLowerCase())) return str

        // знаходжу кількість слів через кількість пробілів
        let spaces = 0
        for( let i = 0; i<str.length; i++) {
            if(str[i] === ' ') spaces++
        }
        // записую трансліт в змінну res
        let res = []
        for (let i = 0; i < str.length; i++) {
                res.push(~orig.indexOf(str[i]) ? trans[orig.indexOf(str[i])] : str[i])
            
        }
        let result = '';
        // додаємо значення в таблиці, розділені пробілами
        let j = 0;
        for(let i = 0; i<= spaces; i++) {
            let strForTableOrig = ``
            let strForTableTrans = ``
            while(j<str.length) {
                if(str[j] === ' ') {
                    j++
                    break;}

                strForTableOrig += `<td>${str[j]}</td>`
                strForTableTrans += `<td>${res[j]}</td>`
                j++
            }
            result += `
            <table style="border-spacing:0px">
                <tr class="ge"">
                    ${strForTableOrig}
                </tr>
                <tr class="ua"  style="color:gray">
                    ${strForTableTrans}
                </tr>
            </table>
            &nbsp;&nbsp;`
        }
        return result
    },
    shuffle(arr) {
        let numbers = arr;
        let first,
            second,
            temp,
            count = numbers.length;
        for (let i = 0; i < 4; i++) {
            first = Math.floor(Math.random() * count);
            second = Math.floor(Math.random() * count);
            temp = numbers[first];
            numbers[first] = numbers[second];
            numbers[second] = temp;
        }
        return numbers;
    },
}

export default func