/*
 * 堆排序算法  
 * 2015-09-15 
 */
#include<stdio.h>
#include<malloc.h>

//交换数组r[i] 和 r[j]的值
void swap(int *r, int i, int j)
{
    int tmp = r[i]; 
    r[i] = r[j]; 
    r[j] = tmp; 
}

//调整r[s]关键字作为根的子树，使r[s..m]成为一个大顶堆
void heapAdjust(int *r, int s, int m)
{
    int temp, j; 
    temp=r[s]; 
    for(j=2*s; j<=m; j*=2)
    {
        //计算r[s]的左右孩子较大的一个
        if(j<m && r[j]<r[j+1])
        {
            ++j; 
        }
        //如果temp为最大，则退出循环，证明目前已经是大顶堆
        if(temp>r[j])
        {
            break; 
        }
        //如果temp不是较大值，那么交互为较大值
        r[s]=r[j]; 
        s=j; 
    }
    r[s]=temp; 
}

/*
* 堆排序
*/
void heap_sort(int *r, int len)
{
    int i; 
    //将数组r构建成为一个大顶堆
    for(i=len/2; i>0; i--)
    {
        heapAdjust(r, i, len); 
    }
    //每循环一次都将树的根结点，从数组最后的位置倒数向前排序
    for(i=len; i>1; i--)
    {
        swap(r, 1, i);  //将数组第一个元素与最后一个元素交换位置
        heapAdjust(r,1,i-1); //第一个元素与最后一个元素交换完毕后，最后一个就不参与调整构建大顶堆了，因为已经有序
    }
}
main(void)
{
    int list[] = {0, 9, 1, 5, 8, 3, 7, 4, 6, 2, 10, 100, 98}; 
    int len,  i; 
    //求数组长度
    len = sizeof(list)/sizeof(int); 
    len = len-1; //len-1 数组下标为0作为哨兵，不计入实际长度
    heap_sort(list, len); 
    for(i=1; i<len+1; i++)
    {
        printf("%d\n", list[i]); 
    }
}
